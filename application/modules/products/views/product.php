<!-- product content wp -->
<style>
.select-option select{
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;}
</style>
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              	<li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
				<?php
					foreach($product->categories as $category){
						if($cate_slug == ''){
							if($category->id == $product->primary_category){
								$primary_category = $category;
								break;
							}
						}else{
							if($category->slug == $cate_slug){
								$primary_category = $category;
								break;
							}
						}
					}
				?>
				<?php
					if(isset($primary_category)){?>
						<li><a href="<?php echo site_url(CATEGORY.'/'.$primary_category->slug);?>"><?php echo $primary_category->name;?></a></li>
				<?php }?>
              	<li class="active"><?php echo $product->name;?></li>
            </ol>
        </div>
        <div class="row">
        	<div class="category-list col-lg-3 col-md-3 col-sm-12 col-xs-12">
            	<div class="left-column-block">
                    <div class="title-left-menu">
                        <h3>Danh mục sản phẩm</h3>
                    </div>
                    <div class="menu-left">
                        <div class="u-vmenu">
                            <ul>
                                <?php category_left(5, 0);?>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
			<?php $_price = get_price_sale($product->price, $product->saleprice, $product->sale_start_date, $product->sale_end_date);?>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            	<div class="quick-view-wp product-detail-wp">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                      <div class="slider-product-wp">
                        <div class="gallery">
                          <div class="full"> 
                            <img alt="<?php echo $product->name;?>" src="<?php echo get_image_primary($product);?>" />
                          </div>
                          <div class="clear"></div>
						  <?php if(count($product->images) > 1){?>
                          <div class="previews">
                            <ul>
                                <?php foreach($product->images as $key=>$image):?>
									<?php if($key == 0){?>
									<li><a title="<?php echo $product->name;?>" class="selected" data-full="/uploads/images/full/<?php echo $image['filename'];?>"><img src="/uploads/images/thumbnails/<?php echo $image['filename'];?>"></a></li>
									<?php }else{?>
									<li><a title="<?php echo $product->name;?>" data-full="/uploads/images/full/<?php echo $image['filename'];?>"><img src="/uploads/images/thumbnails/<?php echo $image['filename'];?>" /></a></li>
									<?php }?>
								<?php endforeach;?>
                            </ul> 
                          </div>
						  <?php }?>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
						<?php echo form_open('cart/add-to-cart', 'id="add-to-cart"');?>
						<input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
						<input type="hidden" name="id" value="<?php echo $product->id?>"/>
                        <div class="des-product-wp">
                            <h1 class="title-des"><?php echo $product->name;?></h1>
							<p class="status">Tình trạng : <span class="pink"><?php if($product->enabled_1 == 1) echo 'Còn hàng'; else echo 'Hết hàng';?></span></p>
							<p class="status">Mã sản phẩm : <span class="pink"><?php echo $product->sku;?></span></p>                            
                            <hr>							
                            <div class="product-price-block">
                                <?php if($_price['sale']){?>
									<p class="product-price"><?php echo format_currency($_price['price']);?></p>
									<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
								<?php }else{?>
									<p class="product-price"><?php echo format_currency($_price['price']);?></p>
								<?php }?>
                            </div>
							<hr>
							<?php if($product->product_type == 1 && isset($product->bonus_product) && is_array($product->bonus_product) && count($product->bonus_product) > 0){?>
								<p><b>Khuyến mãi</b></p>
								<ul>
									<?php foreach($product->bonus_product as $bonus){?>
										<li><a href="<?php echo $bonus->slug;?>"><?php echo $bonus->bonus_name;?></a></li>
									<?php }?>
								</ul>
								<hr>
								<div id="productAlerts"></div>
							<?php }?>

							<?php if($product->product_type == 2 && isset($product->combo_product) && is_array($product->combo_product) && count($product->combo_product) > 0){?>
								<p><b>Combo gồm các sản phẩm:</b></p>
								<ul>
									<?php foreach($product->combo_product as $combo){?>
										<li><a title="<?php echo $combo->name;?>" href="<?php echo site_url('product/'.$combo->slug);?>" target="_blank"><?php echo $combo->name;?></a></li>
									<?php }?>
								</ul>
								<hr>
								<div id="productAlerts"></div>
							<?php }?>							
														
							<?php if(count($options) > 0): ?>
								<?php foreach($options as $option):
									$required = '';
									if($option->required){
										$required = ' class="required"';
									}
									?>
										<div class="row select-option" style="margin-left:0px">
											<div class="pull-left" data-cols="1/3" style="margin-right:10px;margin-top: 8px;">
												<label<?php echo $required;?>><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->name) : $option->name;?></label>
											</div>
											<div class="pull-left form-group" data-cols="2/3">
										<?php
										if($option->type == 'checklist'){
											$value  = [];
											if($posted_options && isset($posted_options[$option->id])){
												$value  = $posted_options[$option->id];
											}
										}
										else{
											if(isset($option->values[0])){
												$value  = $option->values[0]->value;
												if($posted_options && isset($posted_options[$option->id])){
													$value  = $posted_options[$option->id];
												}
											}
											else{
												$value = false;
											}
										}

										if($option->type == 'textfield'):?>
											<input type="text" name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>"/>
										<?php elseif($option->type == 'textarea'):?>
											<textarea name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
										<?php elseif($option->type == 'droplist'):?>
											<select name="option[<?php echo $option->id;?>]">
												<!--<option value=""><?php echo lang('choose_option');?></option>-->

											<?php foreach ($option->values as $values):
												$selected   = '';
												if($value == $values->id){
													$selected   = ' selected="selected"';
												}?>

												<option <?php echo $selected;?> value="<?php echo $values->id;?>">
													<?php if($product->is_giftcard):?>
														<?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo lang($values->name);?>
													<?php else:?>
														<?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo $values->name;?>
													<?php endif;?>
													
												</option>

											<?php endforeach;?>
											</select>
										<?php elseif($option->type == 'radiolist'):?>
											<label class="radiolist">
											<?php foreach ($option->values as $values):

												$checked = '';
												if($value == $values->id){
													$checked = ' checked="checked"';
												}?>
												<div>
													<input<?php echo $checked;?> type="radio" name="option[<?php echo $option->id;?>]" value="<?php echo $values->id;?>"/>
													<?php echo($values->price != 0)?'(+'.format_currency($values->price).') ':''; echo $values->name;?>
												</div>
											<?php endforeach;?>
											</label>
										<?php elseif($option->type == 'checklist'):?>
											<label class="checklist"<?php echo $required;?>>
											<?php foreach ($option->values as $values):

												$checked = '';
												if(in_array($values->id, $value))
												{
													$checked = ' checked="checked"';
												}?>
												<div><input<?php echo $checked;?> type="checkbox" name="option[<?php echo $option->id;?>][]" value="<?php echo $values->id;?>"/>
												<?php echo($values->price != 0 && $option->name != 'Buy a Sample')?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
											<?php endforeach; ?>
											</label>
										<?php endif;?>
										</div>
									</div>
								<?php endforeach;?>
							<?php endif;?>
			
                            <div class="form-inline button-product-detail">
							  <?php if($product->enabled_1 == 1){?>
								  <div class="form-group">
									<label>Số lượng</label>
									<input style="width: 40px;" type="text" class="form-control" name="quantity" value="1">
								  </div>
								  <div class="form-group">
									<a class="btn btn-cart" onclick="addToCart($(this));" product-detail="1"><i class="fa fa-cart-plus"></i> Đặt mua hàng</a>
								  </div>
							  <?php }?>
                              <div class="form-group">
                                <a class="btn btn-wishlist" style="margin-right:0px"><i class="fa fa-heart-o"></i></a>
                              </div>
                            </div>
                            
                        </div>
						</form>
                    </div>
                  </div>
                <hr>
				<div class="row">
				
					<div class="short-des col-sm-12 col-xs-12">
						<ul class="nav nav-tabs" style="font-size:17px">
							<li class="nav active"><a href="#produc-des" data-toggle="tab"> Mô tả sản phẩm</a></li>
							<li class="nav"><a href="#tab-gh" data-toggle="tab"> Giao hàng </a></li>
							<li class="nav"><a href="#tab-th" data-toggle="tab"> Trả hàng </a></li>
							<li class="nav"><a href="#tab-bh" data-toggle="tab"> Bảo hành </a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content" style="margin-top:15px; margin-bottom:10px">
							<div class="tab-pane fade in active" id="produc-des">
								<h2><?php echo html_entity_decode($product->description);?></h2>
							</div>
							<div class="tab-pane fade" id="tab-gh">
								<div align="justify">
									<p>
										<font color="#ff00ff"><strong>I. Vận chuyển/ shipping</strong></font></p>
									<p>
										<font color="#ff00ff"><strong>A. Gói tiết kiệm:</strong> </font><br>
										<br>
										- Địa điểm: nơi xe tải 2 tấn (hẻm rộng &gt; 5m) có thể vào được.</p>
									<p>
										- Đưa hàng nặng, cồng kềnh lên lầu cao ( hoặc chung cư bằng thang bộ): Quý Khách xin vui lòng sử dụng gói giao theo yêu cầu ở dưới đây<br>
										- Thời gian giao hàng: trong vòng 5 ngày đối với nội thành ( 12 ngày đối với ngoại tỉnh) kể từ ngày xác nhận đơn hàng. Bộ phận giao hàng sẽ thông báo giờ giao hàng trước 1 ngày. <br>
										<br>
										<strong><font color="#ff00ff">B. Gói dịch vụ: </font></strong><br>
										- Địa điểm giao hàng: đường cấm xe tải, vào hẻm nhỏ, hoặc khiêng vác lên tầng lầu cao cần ít nhất 2 người.</p>
									<p>
										- Thời gian giao hàng: giao ngay trong ngày theo giờ yêu cầu nếu hàng có sẵn tại kho trung chuyển.</p>
									<p>
										&nbsp;</p>
									<p>
										<font color="#ff00ff"><strong>2. Lắp ráp/ installation</strong></font>
									</p>
									<p>
										- Giá vận chuyển trên đây đã gồm kèm dịch vụ lắp ráp miễn phí đối với các thành phố có kho trung chuyển.
									</p>
									
									<p>
										- QUý khách cần các dịch vụ khác như khoan bắt lên tường, tháo bỏ đồ cũ, cắt thêm kính... Quý khách vui lòng liên hệ trước với chúng tôi để biết chi phí cụ thể.
									</p>
									<p>
										<font color="#ff00ff">* Thông tin hữu ích: </font>Tất cả các sản phẩm đồ gỗ tại Studionoithat.com được thiết kế theo tiêu chuẩn quốc tế. Các liên kết, lỗ ốc vít, số lượng ốc cũng được thiết kế và tính toán chính xác để mọi người đều có thể tự mình lắp ráp một cách dễ dàng.
									</p>
	
								</div>
							</div>
							<div class="tab-pane fade" id="tab-th">
								<p align="justify">
									Đổi trả khi hàng hóa không đúng chất lượng công bố</p>
								<p align="justify">
									Để đảm bảo quyền lợi của khách hàng và trách nhiệm của bên vận chuyển, khách hàng cần kiểm tra hàng hóa kỹ khi nhận hàng. Ngay khi nhận hàng, Quý khách có thể yêu cầu đổi hàng nếu hàng không đảm bảo chất lượng.</p>
								<p align="justify">
									Đổi trả khi không phù hợp với căn nhà</p>
								<p align="justify">
									Ngay khi giao hàng, Quý khách vẫn có thể trả hàng nếu sản phẩm không phù hợp với nội thất chung, Quý Khách sẽ phải thanh toán chi phí vận chuyển:</p>
								<p align="justify">
									+ Chi phí vận chuyển. Trong trường hợp Quý khách đổi ý sau&nbsp; khi xe giao hàng đã đi thì Quý khách sẽ phải trả chi phí vận chuyển 2 chiều ( chiều đi và chiều về) để công ty điều xe khác đến lấy lại hàng. Lưu ý, khi trả lại hàng, bao bì và linh kiện kèm theo phải đầy đủ. Chi phí bao bì trên thị trường hiện nay rất đắt ( thường 1 thùng carton lớn khoảng hơn 100.000 Đ) do vậy, cần bảo quản kỹ thùng khi quyết định trả hàng.</p>
								<p align="justify">
									+ Quý khách sẽ không được trả lại tiền hàng sau khi đã hoàn tất thanh toán.</p>
								
								<p align="justify">
									<font style="font-weight: bold; color: rgb(255, 0, 255);">Trường hợp không được trả hàng</font></p>
								<p align="justify">
									Trong bất kể trường nào sau khi hoàn tất việc giao hàng và thanh toán tiền mua hàng, chúng tôi không chấp thuận việc đổi hay trả hàng do đã hoàn tất việc thanh toán cho nhà máy.</p>
								<p align="justify">
									Trường hợp sản phẩm mất bao bì, không còn nguyên vẹn hoặc hư hỏng do lỗi khách hàng Studionoithat.com có quyền từ chối việc trả hàng như trên.</p>
							</div>
							<div class="tab-pane fade" id="tab-bh">
								<p>
									<strong>Thời hạn bảo hành theo quy định của nhà máy</strong></p>
								<p>
									Mọi sản phẩm của chúng tôi được bảo hành trong vòng 6 tháng kể từ ngày ghi trên phiếu giao hàng.</p>
								<p>
									<strong>Các lỗi được bảo hành trong 6 tháng</strong></p>
								<p>
									a. Gãy vỡ do thiết kế hoặc có lỗi trong quá trình sản xuất. Không bảo hành nếu sử dụng sản phẩm sai mục đích.</p>
								<p>
									b. Sơn bị bong tróc do không dính vào gỗ.</p>
								<p>
									c. Sản phẩm bị mối mọt ăn từ phía trong gỗ ra.</p>
								<p>
									<strong>Phương thức bảo hành</strong></p>
								<p>
									Tùy theo mức độ hư hỏng chúng tôi sẽ tiến hành theo thứ tự các ưu tiên như sau:</p>
								<p>
									1. Sơn dặm, sửa, gia cố sản phẩm: thực hiện trong vòng 1 tuần</p>
								<p>
									2. Đổi sản phẩm tương tự: thực hiện trong vòng 2 tuần nếu sản phẩm đang có sẵn hàng trên web.</p>
								<p>
									3. Hoàn lại tiền sản phẩm không gồm phí vận chuyển: thực hiện trong vòng 1 tháng kể từ ngày thông báo không còn hàng để thay thế.</p>
								<p>
									<strong>Thủ tục bảo hành</strong></p>
								<p>
									1. Liên hệ với bộ phận bán hàng để cung cấp các thông tin: thông tin liên hệ, lỗi bị hư hỏng, mã số đơn hàng.</p>
								<p>
									2. Sản phẩm chỉ được bảo hành tại nhà máy. Chúng tôi sẽ thu xếp hẹn ngày nhận sản phẩm để bảo hành trong vòng 7 ngày. Chúng tôi không chịu chi phí vận chuyển nhận và đổi sản phẩm bảo hành. Chi phí vận chuyển tính theo chính sách tính phí vận chuyển giao hàng tiêu chuẩn.</p>
							</div>
							
						</div>
					</div>
				
				</div>
				
				
				</div>
            </div>
        </div>
        <div class="product-same">
		<?php if(!empty($product->related_products)):?>
			<div class="feature-title-wp text-center" style="border-top: 1px solid #eee;">
                <h3 class="text-uppercase">Sản phẩm liên quan</h3>
                <p><img src="/themes/default/assets/images/icon-title.jpg"></p>
            </div>
			<?php
			$relatedProducts = [];
			foreach($product->related_products as $related)
			{
				$related->images    = json_decode($related->images, true);
				$relatedProducts[] = $related;
			}
			//echo '<pre>'; print_r($product->related_products);
			//\GoCart\Libraries\View::getInstance()->show('categories/products', ['products'=>$relatedProducts]); ?>
			<div class="block-product-scroll block-product-scroll-no margin-tb">
                <div class="owl-carousel3">
					<?php foreach($relatedProducts as $tmp_product){$_price = get_price_sale($tmp_product->price, $tmp_product->saleprice, $tmp_product->sale_start_date, $tmp_product->sale_end_date);?>
					<div class="item">
                        <div class="product-block-wp">
                            <div class="view view-fifth">
                                <div class="icon-status">
                                    <?php if($tmp_product->label_new){?><p class="icon-new">New</p><?php }?>
									<?php if($_price['sale']){?><p class="icon-sale">Sale</p><?php }?>
                                    <!--<p class="icon-bonus">Bonus</p>-->
                                </div>
                                <a title="<?php echo $tmp_product->name;?>" href="<?php echo url_product($tmp_product->slug, $cate_slug);?>">
									<img src="<?php echo get_image_primary_3($tmp_product->images, 'small');?>" alt="<?php echo $tmp_product->name;?>" />
								</a>
                                <div class="">
                                    <div class="hover-icon-1">
                                        <p><a product-id="<?php echo $tmp_product->id?>" data-toggle="modal" data-target="#quick-view"><i class="fa fa-search-plus" aria-hidden="true"></i></a></p>
                                        <p><a class="add-wishlist" href="#!" data-toggle="modal" data-target="#wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></p>
                                        <p><a href="#!" data-toggle="modal" data-target="#cart-add"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></p>
                                    </div>
									<!--
                                    <div class="hover-icon-2">
                                        <ul>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                            <li><p>Tặng khăng trải bàn</p></li>
                                        </ul>   
                                    </div>
									-->
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="description top-pro-cen">
                                <div class="name-product">
                                    <h3><a title="<?php echo $tmp_product->name;?>" href="<?php echo url_product($tmp_product->slug, $cate_slug);?>"><?php echo $tmp_product->name;?></a></h3>
                                </div>
                                <?php if($_price['sale']){?>
								<p class="product-price"><?php echo format_currency($_price['price']);?></p>
								<p class="product-price old"><?php echo format_currency($_price['price_old']);?></p>
							<?php }else{?>
								<p class="product-price"><?php echo format_currency($_price['price']);?></p>
							<?php }?>
                            </div>
                        </div>
					</div>
					<?php }?>
				</div>
			</div>

		<?php endif;?>

		</div>
    </div>
</div>
<!-- end product content wp -->

<script type="application/ld+json">
                    
            {
            "@context": "http://schema.org/",
            "@type": "Product",
            "name": "<?php echo $product->name;?>", 
            "image": "<?php echo get_image_primary($product);?>",
            "description": "<?php echo strip_tags($product->description);?>",            
            "category": {
            "@type": "Thing",
            "name": "<?php if(isset($primary_category->name)) echo $primary_category->name;?>"
            }
            }
        
    </script>
    <script type="application/ld+json">        
            {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item": {
                    "@id": "https://www.studionoithat.com",
                    "name": "Studio Nội Thất"
                }},
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item": {
                    "@id": "<?php if(isset($primary_category->slug)) echo site_url(CATEGORY.'/'.$primary_category->slug);?>",
                    "name": "<?php if(isset($primary_category->name)) echo $primary_category->name;?>"
                }}
            ]}
        
    </script>