@if ($transaction_count == 0)
    <div class="mb-10">
        <h3 class="font-weight-bold">No Transactions added.</h3>
        <div class="font-weight-bold">Please add the transaction to continue to
            portfolio !
        </div>
    </div>
    <div class="mt-10">
        <button type="button" class="btn btn-primary mx-auto my-3" data-toggle="modal"
            data-target="#new_transaction_modal">
            <i class="flaticon2-plus"></i>
            Transaction</button>

        <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#excelImport">
            <i class="flaticon-upload"></i>
            Import</button>
    </div>
@else
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div style="border: 1px solid #d6d6d6; padding:2em;">
                <h5 class="card-title">Your Portfolio : {{ $portfolio_details->portfolio_name }}</h5>
                <h6 class="card-text" id="total_holding_valuation"></h6>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#excelImport">
                    <i class="flaticon-upload"></i>
                    Import</button>
                <button type="button" class="btn btn-primary mx-2 my-3" data-toggle="modal"
                    data-target="#new_transaction_modal">
                    <i class="flaticon2-plus"></i>
                    Transaction</button>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-responsive w-100 d-block d-md-table table-bordered" style="width: 100%">

                <thead>
                    <tr>
                        <th scope="col" colspan="2"></th>
                        @foreach ($asset_matrix_constraints as $constraints)
                            <th scope="col"
                                style="background: {{ $constraints->color }};color:black;text-align:center;">
                                {{ $constraints->market_cap }}
                            </th>
                        @endforeach
                        <th style="text-align:center; border:none;" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            Risk
                        </td>
                        @foreach ($asset_matrix_constraints as $constraints)
                            <td style="text-align:center;">
                                {{ $constraints->risk }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid #ffffff;">Allocation%
                        </td>
                        <td style="text-align: right">
                            <span id="total_allocation" class="ml-auto"></span>
                        </td>
                        <form action="{{ route('percentage.allocation') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $portfolio_details->id }}" name="portfolio_id">
                            <input type="hidden" value="{{ $portfolio_details->portfolio_name }}"
                                name="portfolio_name">
                            @foreach ($asset_matrix_constraints as $constraints)
                                <td>
                                    <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                        {{ $constraints->percentage_allocation }}%
                                    </div>
                                    <input type="text" class="form-control hideBeforeedit hidden"
                                        name="allocation_percentage[]"
                                        value="{{ $constraints->percentage_allocation }}">
                                </td>
                            @endforeach
                            <td colspan="4" style="border: none;">
                                <div class="d-flex justify-content-left">
                                    <button class="btn btn-icon btn-success btn-xs allocationEditBtn" type="button"
                                        data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <button class="btn btn-icon btn-success btn-xs ml-2 allocationSaveBtn hidden"
                                        type="submit" data-toggle="tooltip" title="Submit">
                                        <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </td>
                        </form>
                    </tr>
                    <tr>

                        <td colspan="2">
                            To Allocate $
                        </td>
                        <td style="text-align: right;"><span id="toallocate-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="toallocate-high"></span></td>
                        <td style="text-align: right;"><span id="toallocate-medium"></span></td>
                        <td style="text-align: right;"><span id="toallocate-low"></span></td>
                        <td style="text-align: right;"><span id="toallocate-verylow"></span></td>

                    </tr>
                    <tr>

                        <td colspan="2">
                            Allocated
                        </td>
                        <td style="text-align: right;"><span id="allocated-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="allocated-high"></span></td>
                        <td style="text-align: right;"><span id="allocated-medium"></span></td>
                        <td style="text-align: right;"><span id="allocated-low"></span></td>
                        <td style="text-align: right;"><span id="allocated-verylow"></span></td>
                    </tr>
                    <tr>

                        <td colspan="2">
                            Reallocate
                        </td>
                        <td style="text-align: right;"><span id="not_allocated-veryhigh"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-high"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-medium"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-low"></span></td>
                        <td style="text-align: right;"><span id="not_allocated-verylow"></span></td>
                        <td style="text-align: center;font-weight:bold;" colspan="4">Market</td>
                        
                    </tr>
                </tbody>         
                
                <tbody id="coin_worth_all_summary">
                    <tr>
                        <td colspan="11" style="text-align: center;" class="my-5">
                            <h4>
                                Loading....
                            </h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
