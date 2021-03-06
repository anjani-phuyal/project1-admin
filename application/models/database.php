<?php

class Database extends CI_Model{
	public function login($data){
		$user = $data['user'];
		$pass = $data['pass'];
		$output = $this->db->query("SELECT * FROM `user` WHERE `user_name`='$user' && `password`='$pass'");
		return $output->result();
	}
	
	public function change_password($id,$credentials){
		$this->db->where('user_id',$id);
		$this->db->update('user',$credentials);
	}

	public function category($shop_id){
		$output = $this->db->query("SELECT * FROM `category`");
		$output = $output->result();
		$store = $this->db->query("SELECT * FROM `bookshop` WHERE `shop_id`='$shop_id'");
		$store = $store->result();
		$all = array($output, $store);
		return $all;	
	}
	
	public function search_book($isbn){
		$output = $this->db->query("SELECT * FROM `books` WHERE isbn10='$isbn' OR isbn13='$isbn'");
		return $output->result();
	}
	
	public function img($id){
		$output = $this->db->query("SELECT * FROM `images` WHERE image_id='$id'");
		return $output->result();
	}
	
	public function book_check($book_id){
		$output = $this->db->query("SELECT * FROM `books` WHERE book_id='$book_id'");
		return $output->result();
	}
	
	public function store_check($book_id, $store_id){
		$output = $this->db->query("SELECT * FROM `shopstock` WHERE book_id='$book_id' && store='$store_id'");
		return $output->result();
	}
	
	public function image_id(){
		$output = $this->db->query("SELECT `image_id` FROM `images` ORDER BY `image_id` DESC LIMIT 1");
		return $output->result();
	}
	public function book_id(){
		$output = $this->db->query("SELECT `book_id` FROM `books` ORDER BY `book_id` DESC LIMIT 1");
		return $output->result();
	}
	
	public function bookshop($store_id){
		$output = $this->db->query("SELECT * FROM `bookshop` WHERE shop_id='$store_id'");
		return $output->result();
	}
	
	public function publish_book($book_details, $stock_details, $image_details){
		
		if($image_details == array()){
			//do nothing
		}else{
			$this->db->insert('images', $image_details);

		}
		
		$this->db->insert('books', $book_details);
		$this->db->insert('shopstock', $stock_details);
		
	}
	
	public function input_shopstock($stock_details){
		$this->db->insert('shopstock', $stock_details);
	}
	
	public function store_books($store_id){
		$output = $this->db->query("SELECT * FROM `shopstock` WHERE store ='$store_id'");
		$test = $output->result();
		$all = array();
		$books = array();
		$images = array();
		for($i=0;$i<sizeof($test);$i++){
			$all[$i] = get_object_vars($test[$i]);
			
			$book_id = $all[$i]['book_id'];
			$book_details = $this->db->query("SELECT * FROM `books` WHERE book_id ='$book_id'");
			$book_details = $book_details->result();
			$image_id = $book_details[0]->image_id;
			$book_details = get_object_vars($book_details[0]);
			$books[$i] = $book_details;
			
			$image_details = $this->db->query("SELECT * FROM `images` WHERE image_id ='$image_id'");
			$image_details = $image_details->result();
			$image_details = get_object_vars($image_details[0]);
			$images[$i] = $image_details;
			
		}
		
		$all_details = array($all, $books, $images);
		return $all_details;
	}
	
	public function get_details($book_id, $stock_id, $store_id){
		$all_category = array();
		$book_details = $this->db->query("SELECT * FROM `books` WHERE book_id ='$book_id'");
		$book_details = $book_details->result();
		$image_id = $book_details[0]->image_id;
		
		$category = $book_details[0]->category_id;
		$cat_array = explode(',', $category);
		for($i=0;$i<sizeof($cat_array);$i++){
			$cat_id = $cat_array[$i];
			$category_details = $this->db->query("SELECT * FROM `category` WHERE category_id ='$cat_id'");
			$category_details = $category_details->result();
			$cat = $category_details[0]->name;
			$all_category[$i] = $cat;
		} 
		
		$stock_details = $this->db->query("SELECT * FROM `shopstock` WHERE stock_id ='$stock_id'");
		$stock_details = $stock_details->result();
		
		$image_details = $this->db->query("SELECT * FROM `images` WHERE image_id ='$image_id'");
		$image_details = $image_details->result();
		
		$book_details = get_object_vars($book_details[0]);
		$stock_details = get_object_vars($stock_details[0]);
		$image_details = get_object_vars($image_details[0]);
		
		$all_category = implode(', ', $all_category);
		
		$details = array($book_details, $stock_details, $image_details, $all_category);
		return $details;
	}
	
	public function delete_item($book_id, $stock_id, $store_id){
		$book_details = $this->db->query("SELECT * FROM `books` WHERE book_id ='$book_id'");
		$book_details = $book_details->result();
		$image_id = $book_details[0]->image_id;
		$this->db->query("DELETE FROM `shopstock` WHERE stock_id ='$stock_id'");
	}
	
	public function update_item($book_id, $stock_id, $store_id, $price, $delivery_cost_within_city, $delivery_cost_outof_city, $store_ref, $qty){
		$data = $this->db->query("UPDATE `shopstock` SET price='$price', delivery_cost_within_city='$delivery_cost_within_city', delivery_cost_outof_city='$delivery_cost_outof_city', item_no_for_store_ref='$store_ref', stock='$qty' WHERE stock_id='$stock_id'");
		
	}

	public function confirm_success($store_id, $book_id){
		$output = $this->db->query("SELECT * FROM `shopstock` WHERE store='$store_id' && book_id='$book_id'");
		$output = $output->result();
		$output  = get_object_vars($output[0]);

		$book_details = $this->db->query("SELECT * FROM `books` WHERE book_id='$book_id'");
		$book_details = $book_details->result();
		$book_details = get_object_vars($book_details[0]);
		
		$category = $book_details['category_id'];
		$category = explode(',', $category);
		$cat = array();
		for($i=0;$i<sizeof($category);$i++){
			$cat_id = $category[$i];
			$category_details = $this->db->query("SELECT * FROM `category` WHERE category_id='$cat_id'");
			$category_details = $category_details->result();
			$name = $category_details[0]->name;
			$cat[$i] = $name;
		}
		$category = implode(', ', $cat);

		$image_id = $book_details['image_id'];

		$image_details = $this->db->query("SELECT * FROM `images` WHERE image_id='$image_id'");
		$image_details = $image_details->result();
		$image_details = get_object_vars($image_details[0]);

		$all = array($output, $book_details, $image_details, $category);
		return $all;
	}

	public function quick_search($srch_txt, $store_id){
		$store = array();
		$books = array();
		$images = array();
		$store_details = $this->db->query("SELECT * FROM `shopstock` WHERE store='$store_id'");
		$store_details = $store_details->result();

		$book_details = $this->db->query("SELECT * FROM `books` WHERE book_name LIKE '%$srch_txt%'");
		$book_details = $book_details->result();
		$x=0;
		for($i=0;$i<sizeof($store_details);$i++){
			$book_id = $store_details[$i]->book_id;

			for($j=0;$j<sizeof($book_details);$j++){
				if($book_id==$book_details[$j]->book_id){
					$books[$x] = get_object_vars($book_details[$j]);
					$store[$x] = get_object_vars($store_details[$i]);

					$img_id = $book_details[$j]->image_id;
					$image_details = $this->db->query("SELECT * FROM `images` WHERE image_id='$img_id'");
					$image_details = $image_details->result();
					$images[$x] = get_object_vars($image_details[0]);
					$x++;
				}	
			}
		}
		$all = array($store, $books, $images);
		return $all;
	}


	public function get_order_list($store_id){
		$book_all = array();
		$stock_all = array();
		$order_date = array();
		$order_all = array();
		$customer_details = array();
		$quantity = array();
		

       $order = $this->db->query("SELECT * FROM `order`");

       $order = $order->result();

       foreach ($order as $eachOrder) {

           $cart_id = $eachOrder->cart_id;

           $customer_id = $eachOrder->customer_id;

           $registered = $eachOrder->registered_customer;

           $cart_details = $this->db->query("SELECT * FROM `cart_books` WHERE cart_id='$cart_id'");

           $cart_details = $cart_details->result();

           $saved_cart = $this->db->query("SELECT `update_date` FROM `saved_cart` WHERE cart_id='$cart_id'");

           $saved_cart = $saved_cart->result();

           $update_date = $saved_cart[0]->update_date;

           if($registered==0){
           		$customer = $this->db->query("SELECT * FROM `guest_customer` WHERE customer_id='$customer_id'");

           		$customer = $customer->result();
           }else{
           		$customer = $this->db->query("SELECT * FROM `registered_customer` WHERE customer_id='$customer_id'");

           		$customer = $customer->result();
           }
           $customer = get_object_vars($customer[0]);
           
           $books = array();
		   $stock = array();
		   $quantity_list = array();
           foreach ($cart_details as $eachCart) {
           	
               $stock_id = $eachCart->stock_id;

               $qty = $eachCart->quantity;

               $stock_details = $this->db->query("SELECT * FROM `shopstock` WHERE stock_id='$stock_id'");

               $stock_details = $stock_details->result();

               $book_id = $stock_details[0]->book_id;
               $bookstore_id = $stock_details[0]->store;
               $price = $stock_details[0]->price;


               if($bookstore_id==$store_id){

                   $book_details = $this->db->query("SELECT * FROM `books` WHERE book_id='$book_id'");

                   $book_details = $book_details->result();

                   array_push($books, get_object_vars($book_details[0]));
                   array_push($stock, get_object_vars($stock_details[0]));
                   array_push($quantity, $qty);
                   

               }else{

                   //not from this store
               		continue;

               }

            }
            array_push($book_all, $books);
            array_push($stock_all, $stock);
            array_push($order_date, $update_date);
	        array_push($order_all, get_object_vars($eachOrder));
	        array_push($customer_details, $customer);
	        array_push($quantity_list, $quantity);
       }

       $all = array($order_all, $customer_details, $book_all, $stock_all, $order_date, $quantity);
       return $all;

   }

}

?>