<div>
    @include('livewire.loader')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>{{ trans('titles.products') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="uk-grid-small my-4 d-flex align-items-end" uk-grid>
                    <div>
                        <select wire:model.defer="countryName" name="countryName" id="countryId" class="custom-select">
                            <option value="0">{{ trans('titles.all-countries') }}</option>
                            @foreach ($dingCountries as $item)
                                <option value="{{$item->CountryIso}}">{{$item->CountryName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                    </div>
                    <div class="input-group-append">
                        <button wire:click="commit" class="btn btn-success" type="button"
                            id="commitBtn">{{ trans('titles.commit') }}</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                        <thead>
                        <tr class="cursorPointer">
                            <th wire:click="sortBy('id')">
                                <span class="mr-4">{{ trans('titles.id') }}</span>
                                @if($sortAsc && $sortField == 'id')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('CountryName')">
                                <span class="mr-4">{{ trans('titles.id') }}</span>
                                @if($sortAscCustom && $customSort == 'CountryName')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('Name')"><span class="mr-4">{{ trans('titles.operator-name') }}</span>
                                @if($sortAscCustom && $customSort == 'Name')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('SkuCode')">
                                <span class="mr-4">{{ trans('titles.sku') }}</span>
                                @if($sortAsc && $sortField == 'SkuCode')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th>
                                <span class="mr-4">{{ trans('titles.min-max') }}</span>
                            </th>
                            <th>
                                <span class="mr-4">{{ trans('titles.benefits') }}</span>
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
									            {{ trans('titles.actions') }}
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
													<span>{{ trans('titles.details') }}</span>
                                                </a>
                                                <a class="btn btn-info edit dropdown-item" href="#" data-product-id="{{ $product->id }}">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                        </use>
                                                    </svg>
													<span>{{ trans('titles.edit') }}<span>
                                                </a>
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
                                            {{ $product->minimum->SendValue }} - {{ $product->maximum->SendValue }}
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
