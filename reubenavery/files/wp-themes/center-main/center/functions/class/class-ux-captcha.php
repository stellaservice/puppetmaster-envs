<?php
class UXCaptcha {

	function UXCaptcha() {
		
		$this->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

		$this->char_length = 4;

		$this->fonts = array(
			dirname( __FILE__ ) . '/gentium/GenBkBasR.ttf',
			dirname( __FILE__ ) . '/gentium/GenBkBasI.ttf',
			dirname( __FILE__ ) . '/gentium/GenBkBasBI.ttf',
			dirname( __FILE__ ) . '/gentium/GenBkBasB.ttf' );

		$this->tmp_dir = $this->ux_captcha_tmp_dir();

		$this->img_size = array( 72, 24 );

		$this->bg = array( 255, 255, 255 );

		$this->fg = array( 0, 0, 0 );

		$this->base = array( 6, 18 );

		$this->font_size = 14;

		$this->font_char_width = 15;

		$this->img_type = 'png';

		$this->file_mode = 0444;

		$this->answer_file_mode = 0440;
	}

	function generate_random_word() {
		$word = '';

		for ( $i = 0; $i < $this->char_length; $i++ ) {
			$pos = mt_rand( 0, strlen( $this->chars ) - 1 );
			$char = $this->chars[$pos];
			$word .= $char;
		}

		return $word;
	}

	function generate_image( $prefix, $word ) {
		if ( ! $this->make_tmp_dir() )
			return false;

		$this->cleanup();

		$dir = trailingslashit( $this->tmp_dir );
		$filename = null;

		if ( $im = imagecreatetruecolor( $this->img_size[0], $this->img_size[1] ) ) {
			$bg = imagecolorallocate( $im, $this->bg[0], $this->bg[1], $this->bg[2] );
			$fg = imagecolorallocate( $im, $this->fg[0], $this->fg[1], $this->fg[2] );

			imagefill( $im, 0, 0, $bg );

			$x = $this->base[0] + mt_rand( -2, 2 );

			for ( $i = 0; $i < strlen( $word ); $i++ ) {
				$font = $this->fonts[array_rand( $this->fonts )];

				// sanitize for Win32 installs
				$font = str_replace( '\\', '/', $font );
				$font = preg_replace( '|/+|', '/', $font );

				imagettftext( $im, $this->font_size, mt_rand( -12, 12 ), $x,
					$this->base[1] + mt_rand( -2, 2 ), $fg, $font, $word[$i] );
				$x += $this->font_char_width;
			}

			switch ( $this->img_type ) {
				case 'jpeg':
					$filename = sanitize_file_name( $prefix . '.jpeg' );
					imagejpeg( $im, $dir . $filename );
					break;
				case 'gif':
					$filename = sanitize_file_name( $prefix . '.gif' );
					imagegif( $im, $dir . $filename );
					break;
				case 'png':
				default:
					$filename = sanitize_file_name( $prefix . '.png' );
					imagepng( $im, $dir . $filename );
			}

			imagedestroy( $im );
			@chmod( $dir . $filename, $this->file_mode );
		}

		$this->generate_answer_file( $prefix, $word );

		return $filename;
	}

	function generate_answer_file( $prefix, $word ) {
		$dir = trailingslashit( $this->tmp_dir );
		$answer_file = $dir . sanitize_file_name( $prefix . '.txt' );

		if ( $fh = @fopen( $answer_file, 'w' ) ) {
			$word = strtoupper( $word );
			$salt = wp_generate_password( 64 );
			$hash = hash_hmac( 'md5', $word, $salt );

			$code = $salt . '|' . $hash;

			fwrite( $fh, $code );
			fclose( $fh );
		}

		@chmod( $answer_file, $this->answer_file_mode );
	}

	function check( $prefix, $response ) {
		$response = str_replace( array( " ", "\t" ), '', $response );
		$response = strtoupper( $response );

		$dir = trailingslashit( $this->tmp_dir );
		$filename = sanitize_file_name( $prefix . '.txt' );
		$file = $dir . $filename;

		if ( @is_readable( $file ) && ( $code = file_get_contents( $file ) ) ) {
			$code = explode( '|', $code, 2 );

			$salt = $code[0];
			$hash = $code[1];

			if ( hash_hmac( 'md5', $response, $salt ) == $hash )
				return true;
		}

		return false;
	}

	function remove( $prefix ) {
		$suffixes = array( '.jpeg', '.gif', '.png', '.php', '.txt' );

		foreach ( $suffixes as $suffix ) {
			$filename = sanitize_file_name( $prefix . $suffix );
			$file = trailingslashit( $this->tmp_dir ) . $filename;
			if ( @is_file( $file ) )
				unlink( $file );
		}
	}

	function cleanup( $minutes = 60 ) {
		$dir = trailingslashit( $this->tmp_dir );

		if ( ! @is_dir( $dir ) || ! @is_readable( $dir ) )
			return false;

		$is_win = ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) );

		if ( ! ( $is_win ? win_is_writable( $dir ) : @is_writable( $dir ) ) )
			return false;

		$count = 0;

		if ( $handle = @opendir( $dir ) ) {
			while ( false !== ( $filename = readdir( $handle ) ) ) {
				if ( ! preg_match( '/^[0-9]+\.(php|txt|png|gif|jpeg)$/', $filename ) )
					continue;

				$file = $dir . $filename;
				
				$stat = @stat( $file );
				if ( ( $stat['mtime'] + $minutes * 60 ) < time() ) {
					@chmod( $dir, 0777 );
					@chmod( $file, 0777 );
					@unlink( $file );
					$count += 1;
				}
			}

			closedir( $handle );
		}

		return $count;
	}

	function make_tmp_dir() {
		$dir = trailingslashit( $this->tmp_dir );

		if ( ! wp_mkdir_p( $dir ) )
			return false;

		$htaccess_file = $dir . '.htaccess';

		if ( file_exists( $htaccess_file ) )
			return true;

		if ( $handle = @fopen( $htaccess_file, 'w' ) ) {
			fwrite( $handle, 'Order deny,allow' . "\n" );
			fwrite( $handle, 'Deny from all' . "\n" );
			fwrite( $handle, '<Files ~ "^[0-9A-Za-z]+\\.(jpeg|gif|png)$">' . "\n" );
			fwrite( $handle, '    Allow from all' . "\n" );
			fwrite( $handle, '</Files>' . "\n" );
			fclose( $handle );
		}

		return true;
	}
	
	//captcha tmp dir
	function ux_captcha_tmp_dir(){
		$uploads = wp_upload_dir();
		
		if(defined('UX_CAPTCHA_TMP_DIR')){
			return UX_CAPTCHA_TMP_DIR;
		}else{
			return $uploads['basedir'] . '/ux_captcha';
		}
	}
	
	//captcha tmp url
	function ux_captcha_tmp_url(){
		$uploads = wp_upload_dir();
		
		if(defined('UX_CAPTCHA_TMP_URL')){
			return UX_CAPTCHA_TMP_URL;
		}else{
			return $uploads['baseurl'] . '/ux_captcha';
		}
	}
}

?>