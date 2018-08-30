<!-- product content wp -->
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active">Liên Hệ</li>
            </ol>
        </div>
        <div class="row block-news">
        	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="google-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2306289669655!2d106.58506131530257!3d10.793640261826027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752dcd3c3419ef%3A0xb3b2176c397b8e7f!2sSTUDIONOITHAT!5e0!3m2!1svi!2s!4v1473652914818" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                    </div>
                </div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="address-wp">
                        <ul>
                            <li><i class="glyphicon glyphicon-home"></i> 123/2 Liên Khu 4-5, phường Bình Hưng Hoà B, Quận Bình Tân, HCM.</li>
                            <li><i class="glyphicon glyphicon-phone-alt"></i> 0903 935 666 (Mr.Linh)</li>
                        </ul>
                    </div>
                    <?php if(isset($thanks_for_contact)){?>
                        <div class="alert alert-success">
                            Cám ơn quý khách đã liên hệ. Chúng tôi sẽ sớm phản hồi với quý khách.
                        </div>
                    <?php }?>
					<?php if(isset($recaptcha) && $recaptcha == false){?>
                        <div class="alert alert-warning">
                            Vui lòng click vào reCaptcha để xác nhận khi gởi.
                        </div>
                    <?php }?>
                    <div>
						<form id="form_contact" method="post">
						  <div class="form-group">
							<label>Họ và tên</label>
							<input required name="fullname" type="text" class="form-control" placeholder="" value="<?php if(isset($post['fullname'])) echo $post['fullname'];?>">
						  </div>
						  <div class="form-group">
							<label>Email</label>
							<input required name="email" type="email" class="form-control" placeholder="" value="<?php if(isset($post['email'])) echo $post['email'];?>">
						  </div>
						  <div class="form-group">
							<label>Nội dung</label>
							<textarea required name="content" class="form-control" rows="4"><?php if(isset($post['content'])) echo $post['content'];?></textarea>
						  </div>
						  <div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LeDCFgUAAAAAC43Kc3Ow50k_0InVa7mh6q-xU-A"></div>
						  </div>
						  <button type="text" class="btn btn-danger">Gởi</button>
						  <p></p>
						 </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- end product content wp -->