<?php 
    include("header-dash.php");
?>
    <!-- End: HEADER -->
    <!-- Start: MAIN CONTENT -->
    <div class="content content-dash">
      <!-- Start: container -->
        <div class="container">
          <div class="row-fluid">
            <div class="span3">
            <?php 
              include("sidebar-dash.php");
            ?>
            </div>
            <!-- start:section2 -->
            <div class="section2  span9">
                <section id="main" class="column">
    
                    <div class="clear"></div>
                    <article class="module width_full">
                      <header><h3>Publish a Book</h3></header>
                        <div class="module_content">
                            <form action="<?php echo base_url();?>publish" method="post" id="publish" name="publish">
                        <fieldset style="width:48%; float:left; margin-right: 3%;"> 
              <label>ISBN 10 *</label>
              <input type="text" name="isbn10" id="isbn10" placeholder="0123456789" style="width:92%;">
            </fieldset>
                        <fieldset style="width:48%; float:left;">
              <label>ISBN 13 *</label>
              <input type="text" name="isbn13" id="isbn13" placeholder="01234567891234" style="width:92%;">
            </fieldset><div class="clear"></div>
                        <fieldset>
              <label>Book Title *</label>
              <input type="text" name="book_name" id="book_name">
            </fieldset>
            
            
            <fieldset style="width:48%; float:left; margin-right: 3%;">
              <label>Author *</label>
              <input type="text" name="author" id="author" style="width:92%;">
            </fieldset>
            <fieldset style="width:48%; float:left;">
              <label>Publisher *</label>
              <input type="text" name="publisher" id="publisher" style="width:92%;">
            </fieldset>
            <fieldset style="width:48%; float:left; margin-right: 3%;">
              <label>Year Of Publication *</label>
              <input type="text" name="published_date" id="published_date" style="width:92%;">
            </fieldset>
            <fieldset style="width:48%; float:left;">
              <label>Language *</label>
              <input type="text" name="language" id="language" style="width:92%;">
            </fieldset>
            <fieldset style="width:48%; float:left; margin-right: 3%;"> 
              <label>Price *</label>
              <input type="text" name="price" id="price" style="width:92%;">
            </fieldset>
            <fieldset style="width:48%; float:left;"> 
              <label>Weight</label>
              <input type="text" name="weight" id="weight" style="width:92%;">
            </fieldset><div class="clear"></div>
                        
                        
            <fieldset style="width:48%; float:left; margin-right: 3%;"> 
              <label>Category *</label>
              <select name="category_id" id="category_id" style="width:92%;">
                <option value="Please Choose...">Please Choose...</option>
                <?php 
                  for($i=0;$i<sizeof($category);$i++){
                ?>
                                <option value="<?php echo $category[$i]->category_id;?>"><?php echo $category[$i]->name;?></option>
                                <?php   
                  }
                ?>
              </select>
            </fieldset>
            <fieldset style="width:48%; float:left;"> 
              <label>Delivery Cost Within City</label>
              <input type="text" name="delivery_cost_within_city" id="delivery_cost_within_city" style="width:92%;">
            </fieldset><div class="clear"></div>
                        
                        <fieldset style="width:48%; float:left;"> 
              <label>Delivery Cost Out Of City</label>
              <input type="text" name="delivery_cost_outof_city" id="delivery_cost_outof_city" style="width:92%;">
            </fieldset>
                        <fieldset style="width:48%; float:right;"> 
              <label>Store Item Reference</label>
              <input type="text" name="store_ref" id="store_ref" style="width:92%;">
            </fieldset><div class="clear"></div>
                        <div id="popup" style="background-color:green; display:none; width:48%; margin-left:25%; height:90px; color:white; z-index:100; text-align:center; vertical-align:middle; font-size:36px;"></div>
                        <div class="clear"></div>
            <fieldset style="width:48%; float:left;"> 
              <label>Image</label>&nbsp;
              <input type="file" name="image" id="image" onChange="readURL(this);" style="width:92%;">
              <br /><img  style="display:none;" id="img_prev" src="#" alt="Image Preview" />
                      </fieldset>
                        <fieldset style="width:48%; float:right;"> 
              <label>Quantity *</label>
              <input type="text" name="qty" id="qty" style="width:92%;" />
            </fieldset>
                        <div class="clear"></div>
                        <fieldset>
              <label>Description *</label>
              <textarea name="description" id="description" rows="12"></textarea>
            </fieldset>
            <input type="hidden" name="book_id" id="book_id" >
                        <input type="hidden" name="isbn_check" id="isbn_check" value="0" />
                       </form>
                        </div>
                      <footer>
                        <div class="submit_link">
                          <select>
                            <option>Draft</option>
                            <option>Published</option>
                          </select>
                          <input type="submit" id="submit" value="Publish" class="alt_btn" />
                          <input type="submit" value="Reset" id="reset" />
                        </div>
                      </footer>
                    </article><!-- end of post new book entry -->
                    
                    <div class="spacer"></div>
                  </section>
                            </div></div>
                <!-- end:section2 -->
            </div>
        </div>
      <!-- End: container -->
    </div>
    
    <!-- End: FOOTER -->
    <?php  
      include("footer-dash.php");
    ?>