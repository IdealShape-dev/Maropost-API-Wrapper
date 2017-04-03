<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:12 AM
 */

namespace Maropost;


class content_image extends maropost {
	function post_new_list( array $list ) {
		return $this->request( "POST", "content_images", null);
	}
}