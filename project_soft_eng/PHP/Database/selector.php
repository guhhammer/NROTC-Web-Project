<?php 

	//The function are to be used by every other file, wishing to select information from the database.
	class Selector{

		private $connection = false;

		private function set_connection(){
			$this->connection = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
		}

		public function end_connection(){
			$this->connection->close();
		}

		// Returns the select array transformed into a string.
		private function select_to_string($select_arr){

			$select_str = "";
			for($i = 0; $i < sizeof($select_arr); $i++){ 
				$select_str =  $select_str."`".$select_arr[$i]."`";
				if( $i < sizeof($select_arr)-1 && sizeof($select_arr) > 1){ $select_str = $select_str.", ";}
			}

			return $select_str;

		}


		private function set_to_string($column_names, $new_values){
				
			$set_str = "";
			for($i = 0; $i < sizeof($column_names); $i++){
				$set_str = $set_str.$column_names[$i]."='".$new_values[$i]."'";
				if( $i < sizeof($column_names)-1 && sizeof($column_names) > 1){ $set_str = $set_str.", "; }
			}

			return $set_str;

		}


		// Returns the where array transformed into a string.
		private function where_to_string($where_arr){

			$where_str = "";
			for($i = 0; $i < sizeof($where_arr); $i++){
				$where_str = $where_str.$where_arr[$i][0]."='".$where_arr[$i][1]."'";
				if($i < sizeof($where_arr)-1 && sizeof($where_arr) > 0){ $where_str = $where_str." and "; }
			}

			return $where_str;

		}


		// Returns the where amplified array transformed into a string.
		private function where_to_string_amplified($where_arr){

			$where_str = "";
			for($i = 0; $i < sizeof($where_arr); $i++){
				$where_str = $where_str.$where_arr[$i][0].$where_arr[$i][1]."'".$where_arr[$i][2]."'";
				if($i < sizeof($where_arr)-1 && sizeof($where_arr) > 0){ $where_str = $where_str." and "; }
			}

			return $where_str;

		}


		// Used for general structured searchs: SELECT ... FROM ... (WHERE ...)*; * -> optional.
		// Extracts from the database and store into array.
		private function extractor($save_into, $select_arr, $query){

			if(!$this->connection){ $this->set_connection(); }

			if(!$this->connection){ return "not ok"; }
			else{

				$result = $this->connection->query($query);
			
			    while($row = $result->fetch_assoc()) {

			    	for($i = 0; $i < sizeof($select_arr); $i++){

			    		array_push($save_into[$i], $row[$select_arr[$i]]);
			    		
			    	}

				}

				return "ok";

			}

		}


		// Used for SELECT * searchs.
		// Extracts from the database and returns.
		private function extractor_all($query){

			if(!$this->connection){ $this->set_connection(); }

			if(!$this->connection){ return ["not ok", []]; }
			else{

				$result = $this->connection->query($query);
					    
				$row_str = [];
			    while($row = $result->fetch_assoc()) { array_push($row_str, $row); }

				return ["ok", $row_str];

			}

		}


		/*
			Specially made for homepage. Do not change it.
		*/
		private function extractor_file($query, $name){

			if(!$this->connection){ $this->set_connection(); }

			if(!$this->connection){ return ["not ok", []]; }
			else{

				$result = $this->connection->query($query);
					    
				$row_str = [];
			    while($row = $result->fetch_assoc()) { 

			    	if(!($row[$name] === "")){


			    		$extension = explode(".", $row[$name."_name"]);
			    		$extension = $extension[sizeof($extension)-1];

				    	header('Content-Description: File Transfer');
					    header('Content-Type: application/'.$extension);
					    header('Content-Disposition: attachment; filename="'. $row[$name."_name"] . '"' ); 
					    header('Content-Transfer-Encoding: binary');
					    header('Connection: Keep-Alive');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					    header('Pragma: public');

			    	}

			    	array_push($row_str, file_put_contents($row[$name."_name"], $row[$name]));
			    	break;

			   	}

				return ["ok", $row_str];

			}

		}



		private function setter($query){

			if(!$this->connection){ $this->set_connection(); }

			if(!$this->connection){ return "not ok"; }
			else{

				$this->connection->query($query);
					    
				return "ok";

			}


		}


		private function deleter($query){

			if(!$this->connection){ $this->set_connection(); }

			if(!$this->connection){ return "not ok"; }
			else{

				$this->connection->query($query);
					    
				return "ok";

			}

		}


		private function check_flag($flag){

			$flags = ["ORDER", "BY", "LIMIT", "ASC", "DESC"];

			$string = explode(" ", $flag);

			for($i = 0; $i < sizeof($string); $i++){ if(in_array(strtoupper($string[$i]), $flags)){ $string[$i] = strtoupper($string[$i]); } }

			return implode(" ", $string);

		}

		
		// Stores the values of a search.
		// If it's a SELECT * search, it returns the value as a string.
		// Returns false if array sizes are not equal.
		// More info after the function scope.
		public function getValues($save_into, $select_arr, $from, $where_arr, &$status){

			$flags = ""; 
			if(func_num_args() > 5){ $flags = $this->check_flag(func_get_args()[5]); }

			if(is_string($select_arr) && $select_arr == "*"){

				$where_str = (
					 		  (is_array($where_arr) == 0 || sizeof($where_arr) == 0)
								? ""
								: ( sizeof($where_arr) > 0 && sizeof($where_arr[0]) > 2)
									? $this->where_to_string_amplified($where_arr)
									: $this->where_to_string($where_arr)
								  
							 ); 	

				$query = ((strlen($where_str) > 0) 
							? "SELECT * FROM $from WHERE $where_str $flags;" 
							: "SELECT * FROM $from $flags");

				$extracted = $this->extractor_all($query);

				$status = $extracted[0];

				return $extracted[1];

			}
			else{

				if(sizeof($save_into) == sizeof($select_arr)){

					$select_str = $this->select_to_string($select_arr);

					$where_str = (
						 		  (is_array($where_arr) == 0 || sizeof($where_arr) == 0)
									? ""
									: ( sizeof($where_arr) > 0 && sizeof($where_arr[0]) > 2)
										? $this->where_to_string_amplified($where_arr)
										: $this->where_to_string($where_arr)
									  
								 ); 	



					$query = ((strlen($where_str) > 0) 
								? "SELECT $select_str FROM $from WHERE $where_str;" 
								: "SELECT $select_str FROM $from");

					$status = $this->extractor($save_into, $select_arr, $query);

					return true;



				}

				return false;

			}

		}
		/*
			Info on how to use the function:

				Type one:
				    ---------------------------------------------------------
					getValues([ ], "*", $from, $where_arr, &$status)
							   ^    ^     ^       ^          ^
							   |    |     |       |          |
							   1    2     3       4          5
                        ----------------------------------------------------
					    Basic structure of a SELECT * search: 
					    .1 ->  Empty array
					    .2 ->  "*"; obrigatory value needs to be "*".
					    .3 ->  string containing only the table name.
					    .4 ->  optional.
					         .4a -> for no where condition flags pass value ""(empty string) or [] (empty array, recommended most).
					         .4b -> for where conditon flags type an array.
					         	.4ba -> an array with size-2-array elements will make the search with equality sign '=' between flags.
					         	.4bb -> an array with size-3-array elements shall be like: [  [("column-name"), ("compare-sign: '=','<',etc"), value], ... ].
					    .5 -> flag passed by reference to indicate if connection to the database was established.
						
						every element on the $save_into array must be passed by reference.

				Type two:
					---------------------------------------------------------
					getValues([...], [...], $from, $where_arr, $status) 
							    ^      ^      ^       ^          ^
							    |      |      |       |          |
							    1      2      3       4          5
                        ----------------------------------------------------
						
						The sizes of $save_into and $select_arr arrays must be equal.


						Every index on $select_arr array match the index with the same value
						on the $save_into array. For example:
							$save_into = [ &$var1, &$var2, ...]  <- Array of variables passed by reference to store the column values.
							                 ^      ^
					    		             |      |
							$select_arr = [ "id", "rank", ...]  <- column value names that will be extracted.

				
				Example of $where_arr array values:

					$where_arr = []  <- no condition flags. 

					$where_arr = [ ["id", $id], ... ]  <- with condition flags.

					$where_arr [ ["id","<", $id], ...] <- with condition flags, indicating the comparison to be made.
				
				By adding a sixth parameter users are alowed to constrain even more the result set.For example:
					"ORDER BY username".
				
				This function should be imported and used by every other file that wishes to select info.

		*/


		/*
			Function used to modify values in the table.
		*/
		public function setValues($update_table, $column_names, $new_values, $where_arr, &$status){

			if(sizeof($column_names) > 0 && sizeof($column_names) == sizeof($new_values)){

				$set_str = $this->set_to_string($column_names, $new_values);

				$where_str = (
						 		  (is_array($where_arr) == 0 || sizeof($where_arr) == 0)
									? ""
									: ( sizeof($where_arr) > 0 && sizeof($where_arr[0]) > 2)
										? $this->where_to_string_amplified($where_arr)
										: $this->where_to_string($where_arr)
							 ); 	


				$query = "UPDATE $update_table SET $set_str WHERE $where_str";
				
				$status = $this->setter($query);

			}

		}


		/*
			Function used to delete values in the table.
		*/
		public function deleteValue($from, $column_name, $column_value, &$status){

			$query = "DELETE FROM $from WHERE $column_name='$column_value'";

			$status = $this->deleter($query);

		}


		/*
			Specially made for homepage. Do not change it. 
		*/
		public function getFile($select, $from, $where_arr, &$status){


			$status = "ok";

			$where_str = (
				 		  (is_array($where_arr) == 0 || sizeof($where_arr) == 0)
							? ""
							: ( sizeof($where_arr) > 0 && sizeof($where_arr[0]) > 2)
								? $this->where_to_string_amplified($where_arr)
								: $this->where_to_string($where_arr)
							  
						 ); 	

			$query = ((strlen($where_str) > 0) 
						? "SELECT * FROM $from WHERE $where_str;" 
						: "SELECT * FROM $from");

			$extracted = $this->extractor_file($query, $select);

			$status = $extracted[0];

			return $extracted[1]; 

		}


	}

?>