<div>
    @include('livewire.loader')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Prodotti</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="uk-grid-small my-4 d-flex align-items-end" uk-grid>
                    <div>
                        <select wire:model.defer="countryName" name="countryName" id="countryId" class="custom-select">
                            <option value="0">All countries</option>
                            @foreach ($dingCountries as $item)
                                <option value="{{$item->CountryIso}}">{{$item->CountryName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select wire:model.defer="type" name="typesList" id="typesId" class="custom-select">
                            <option value="0">Every type</option>
                            @foreach ($typesList as $item)
                                <option value="{{$item->denominationType}}">{{$item->denominationType}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button wire:click="commit" class="btn btn-success" type="button"
                            id="commitBtn">Commit</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                        <thead>
                        <tr class="cursorPointer">
                            <th wire:click="sortBy('id')">
                                <span class="mr-4">ID</span>
                                @if($sortAsc && $sortField == 'id')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('CountryName')">
                                <span class="mr-4">Country</span>
                                @if($sortAscCustom && $customSort == 'CountryName')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('Name')"><span class="mr-4">Operator name</span>
                                @if($sortAscCustom && $customSort == 'Name')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('SkuCode')">
                                <span class="mr-4">Sku</span>
                                @if($sortAsc && $sortField == 'SkuCode')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th>
                                <span class="mr-4">Max - Min</span>
                            </th>
                            <th>
                                <span class="mr-4">Benifits</span>
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                        @foreach ($livewireProducts as $product)
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                            {{ $product->id }}
                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">
									            Actions
								            </span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="uk-width-small">
                                                <a class="btn btn-success details dropdown-item" href="#"
                                                   data-product-id="{{ $product->id }}">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass">
                                                        </use>
                                                    </svg>
													<span>Details</span>
                                                </a>
                                                <a class="btn btn-info edit dropdown-item" href="#" data-product-id="{{ $product->id }}">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                        </use>
                                                    </svg>
													<span>Edit<span>
                                                </a>
                                                @if ($product->denominationType == 'FIXED' && $product->localFixedAmounts->count() > 0)
                                                    <a class="btn btn-info edit-local dropdown-item" href="#"
                                                       data-product-id="{{ $product->id }}">
                                                        <svg class="c-icon">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                            </use>
                                                        </svg>
														<span>Edit local</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ isset($product->operator) && isset($product->operator->country) ? $product->operator->country->CountryName : 'Not set yet' }}</td>
                                <td>{{ isset($product->operator) ? $product->operator->Name : 'returning null' }}</td>
                                <td>{{ $product->SkuCode }}</td>
                                <td>
                                    @if(isset($product->maximum) && isset($product->minimum))
                                        @if ($product->maximum->SendValue == $product->minimum->SendValue)
                                            {{ $product->maximum->SendValue }}
                                        @else
                                            Max: {{ $product->maximum->SendValue }} - Min: {{ $product->minimum->SendValue }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ $product->benefits->pluck('benefit')->implode(', ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                {{ $livewireProducts->links() }}
            </div>
        </div>
    </div>
</div>
