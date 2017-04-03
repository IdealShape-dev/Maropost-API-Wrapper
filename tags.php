<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:13 AM
 */

namespace Maropost;


class tags extends maropost  {
	function get_tags(  ) {
		return $this->request( "GET", "tags", null );
	}


	/**
	 *
	 * @param array $tags
	<tag>
		<name>male</name>
	</tag>
	 * @return mixed
	 */
	function post_tags( array $tags ) {
		return $this->request( "POST", 'tags', array("tag" =>$tags["tags"]) );
	}

	/**
	 * @param array $tags
	 *
	<tags>
		<email>test@gmail.com</email>
		<add-tags type="array">
			<add-tag>tag_name</add-tag>
			<add-tag>tag_name</add-tag>
		</add-tags>
		<remove-tags type="array">
			<remove-tag>tag_name</remove-tag>
			<remove-tag>tag_name</remove-tag>
		</remove-tags>
	</tags>
	 *
	 * @return mixed
	 */
	function put_add_remove_tags( array $tags ) {
		return $this->request( "PUT", 'add_remove_tags', array("tags" => $tags["tags"]) );
	}

	/**
	 * @param array $tags
	 *
	 * @return mixed
	 */
	function delete_tag_by_id ( array $tags ) {
		return $this->request( "DELETE", 'tags/'.$tags['tag_id'], null);
	}
}