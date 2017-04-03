<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:20 AM
 */

namespace Maropost;


class relational_tables extends maropost  {
	/**
	 * To get a list of relational_tables
	 * @return mixed
	 */
	function get_tables(  ) {
		return $this->request( "GET", "relational_tables", null );
	}

	/**
	 * To get a table by id
	 * @param array $tables
	 * requires $table['table_id'];
	 * truncates table if $tables['truncate'] is set to true
	 *
	 * @return mixed
	 */
	function get_table_by_id( array $tables ) {
		$path = "relational_tables/".$tables['table_id'];
		$path = empty($tables['truncate'])?$path:$path."/truncate";
		return $this->request( "GET", $path, null );
	}

	/**
	 * @param array $tables
	 *
	 * @return mixed
	 */
	function post_table( array $tables ) {
		return $this->request( "POST", 'relational_tables', array("relational_table" =>$tables["relational_table"]) );
	}

	/**
	 * @param array $tables
	 *
	 * @return mixed
	 */
	function put_update_table_by_id( array $tables ) {
		return $this->request( "PUT", 'relational_tables/'.$tables['table_id'], array("relational_table" =>$tables["relational_table"]) );
	}

	/**
	 * @param array $tables
	 *
	 * @return mixed
	 */
	function delete_table_by_id( array $tables ) {
		return $this->request( "PUT", 'relational_tables/'.$tables['table_id'], null );
	}

}