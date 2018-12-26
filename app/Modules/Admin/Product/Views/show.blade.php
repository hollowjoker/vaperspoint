@if(count($data))
	@foreach($data as $k => $v)
		<div class="col-md-4 my-3">
			<div class="card">
				<div class="image-juices" style="background-image: url('images/mango_factory.jpg')" alt="Juices"></div>
			
				<div class="card-body main-bg-color">
					<div class="d-flex mb-4">
						<h3 class="flex-grow-1">{{ $v['name'] }}</h3>

						<button class="btn btn-sm btn-dark-color">
							<i class="fa fa-edit"></i>
						</button>
					</div>

					<div class="product-description">
						@if(isset($v['item']) && count($v['item']))
							@foreach($v['item'] as $itemKey => $itemValue)
								<p>{{ $itemValue['name'] }}</p>
								@if(isset($itemValue['item_detail']) && count($itemValue['item_detail']) )
									<ul>
										@php
											$size = [];
											$nic = [];
										@endphp
										@foreach($itemValue['item_detail'] as $newK => $newV)
											@php
												$nic[] = array(
													'size' => $newV['size'],
													'nic' => $newV['nic'],
													'quantity' => $newV['quantity']
												);
											@endphp
										@endforeach
										@foreach($nic as $itemDetailKey => $itemDetailValue)
											@php
												$size[$itemDetailValue['size']][] = $itemDetailValue;
											@endphp
										@endforeach
										@foreach($size as $sizeKey => $sizeValue)
											@php $sizeSwitch = 1; @endphp
											@if(count($sizeValue))
												<li>
													@foreach($sizeValue as $detailKey => $detailValue)
														@if($sizeSwitch)
															{{ $detailValue['size'] }} ml
															@php $sizeSwitch = 0; @endphp
														@endif
														@php
															$nicVol = '';
															if($detailValue['nic'] <= 3){
																$nicVol = 'low';
															}
															elseif($detailValue['nic'] <= 6){
																$nicVol = 'mid';
															}
															elseif($detailValue['nic'] <= 9){
																$nicVol = 'high';
															}
															elseif($detailValue['nic'] <= 12){
																$nicVol = 'xhigh';
															}
														@endphp
														<span class="{{ $nicVol }}">{{ $detailValue['nic'] }} ({{ $detailValue['quantity'] }} pcs)</span>
													@endforeach
												</li>
											@endif
										@endforeach
									</ul>
								@endif
								<hr>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endif