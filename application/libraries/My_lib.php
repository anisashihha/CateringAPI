<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * My_lib class
 * Use for own library
 *
 * @author    Shaquille Demsi
 * @license   
 */
class My_lib {
	public function hashing($pwd) {
		$options = [
		'cost' => 11,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];

		return password_hash($pwd, PASSWORD_BCRYPT, $options);
	}
}