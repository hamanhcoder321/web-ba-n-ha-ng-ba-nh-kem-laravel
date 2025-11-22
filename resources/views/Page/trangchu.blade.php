@extends('master')
@section('content')
    <div class="fullwidthbanner-container">
		<div class="fullwidthbanner">
			<div class="bannercontainer" >
				<div class="banner">
					<ul>
					@foreach($slide as $sl)
						<li data-transition="boxfade" data-slotamount="20" class="active-revslide current-sr-slide-visible" 
						style="width: 100%; height: 100%; overflow: hidden; visibility: inherit; opacity: 1; z-index: 20;">
							<div class="slotholder" 
							style="width:100%;height:100%;" data-duration="undefined" data-zoomstart="undefined"
							data-zoomend="undefined" data-rotationstart="undefined" data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined" data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined" data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined" data-oheight="undefined">
								<div 
								class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined" 
								src="source/image/slide/{{$sl->image}}" 
								data-src="source/image/slide/{{$sl->image}}" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; 
								background-image: url('source/image/slide/{{$sl->image}}'); 
								background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
								</div>
							</div>
						</li>
					@endforeach
					</ul>
				</div>
			</div>
			
			<div class="tp-bannertimer"></div>
		</div>
    </div>
    <!--slider-->
	<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<h4>Sản phẩm mới</h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy {{count($new_product)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
							    @foreach($new_product as $new)
									<div class="col-sm-3">
										<div class="single-item">
											<div class="single-item-header">
												<a href="{{route('chi-tiet-san-pham', $new->id)}}"><img src="source/image/product/{{$new->image}}" alt=""></a>
											</div>
											<div class="single-item-body">
												<p class="single-item-title">{{$new->name}}</p>
												<p class="single-item-price">
													<span>{{number_format($new->unit_price)}} đồng</span>
												</p>
												
											</div>
											<div class="single-item-caption">
												<a class="add-to-cart pull-left" href="{{route('Themgiohang', $new->id)}}"><i class="fa fa-shopping-cart"></i></a>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="row">{{$new_product->links()}}</div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h4>Sản phẩm khuyến mại</h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy {{count($sanpham_khuyenmai)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
								@foreach($sanpham_khuyenmai as $spkm)
									<div class="col-sm-3">
										<div class="single-item">
											<div class="single-item-header">
												<a href="{{route('chi-tiet-san-pham', $new->id)}}"><img src="source/image/product/{{$spkm->image}}" alt="" height="250px"></a>
											</div>
											<div class="single-item-body">
												<p class="single-item-title">{{$spkm->name}}</p>
												<p class="single-item-price">
													<span>{{number_format ($spkm->unit_price)}} đồng</span>
												</p>
											</div>
											<div class="single-item-caption">
												<a class="add-to-cart pull-left" href="{{route('Themgiohang', $new->id)}}"><i class="fa fa-shopping-cart"></i></a>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="row">{{$sanpham_khuyenmai->links()}}</div>
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div>
@endsection
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="Xinchào"
  agent-id="8cc0ecc9-f310-4c3c-af68-b78cc652808a"
  language-code="en"
></df-messenger>