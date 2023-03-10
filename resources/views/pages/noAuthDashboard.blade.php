<meta name="csrf-token" content="{{ csrf_token() }}" />
{{-- <a href="{{ route('login') }}" class="btn btn-primary mb-3"><i class="fa fa-solid fa-arrow-left"></i>Back</a> --}}
<div class="card card-custom">
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header align-items-center border-0 mt-4">
            <h3 class="card-title align-items-start flex-column">
                <span class="font-weight-bold text-dark">Portfolio created based on 20% risk factor and hence shows your
                    current allocation vs the allocation with selected risk factor. To manage portfolio sign in….</span>
                <span class="text-muted mt-5 font-weight-bold font-size-sm">{{ count($wallet_list) }} address
                    <button class="btn btn-icon btn-success btn-xs mx-3" type="button" data-toggle="modal"
                        data-target="#my_wallet_addresses">
                        <i class="fa fa-pen"></i>
                    </button></span>
                <input type="hidden" id="all_wallet_address" value="{{ $wallet_address }}">
            </h3>
            <div class="card-toolbar">

            </div>

            <div class="dropdown">
                <div class="dropdown dropdown-inline mr-4">
                    <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Share
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15"
                            height="15" viewBox="0 0 26 26">
                            <path
                                d="M 21 0 C 18.238281 0 16 2.238281 16 5 C 16 5.085938 16.027344 5.164063 16.03125 5.25 L 8.1875 9.1875 C 7.320313 8.457031 6.222656 8 5 8 C 2.238281 8 0 10.238281 0 13 C 0 15.761719 2.238281 18 5 18 C 6.222656 18 7.320313 17.542969 8.1875 16.8125 L 16.03125 20.75 C 16.027344 20.835938 16 20.914063 16 21 C 16 23.761719 18.238281 26 21 26 C 23.761719 26 26 23.761719 26 21 C 26 18.238281 23.761719 16 21 16 C 19.777344 16 18.679688 16.457031 17.8125 17.1875 L 9.96875 13.25 C 9.972656 13.164063 10 13.085938 10 13 C 10 12.914063 9.972656 12.835938 9.96875 12.75 L 17.8125 8.8125 C 18.679688 9.542969 19.777344 10 21 10 C 23.761719 10 26 7.761719 26 5 C 26 2.238281 23.761719 0 21 0 Z">
                            </path>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <button id="copy-button" onclick="copyToClipboard()"
                            class="btn btn-outline-secondary dropdown-item">
                            <i class="flaticon2-copy" style="align-self:center;"></i> Copy to clipboard
                        </button>
                        <button id="copy-button" onclick="composeEmail()"
                            class="btn btn-outline-secondary dropdown-item">
                            <i class="flaticon2-mail" style="align-self:center;"></i> Email
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="timeline timeline-6">
                @foreach ($wallet_list as $item)
                    <div class="timeline-item align-items-start">
                        <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"></div>
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-success icon-xl"></i>
                        </div>
                        <div class="timeline-content d-flex">
                            <span class="font-weight-bolder text-dark-75 pl-3 font-size-lg">
                                {{ $item }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <h4 class="px-10 font-weight-bolder text-dark" id="total_holding_valuation"></h4>


        <div class="card-body">
            <div class="card d-none" id="error-box-api-rate-limit">
                <p class="p-2 text-danger text-sm">There has been error in fetching data from API. Click here
                    to refresh.
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        Refresh
                    </button>
                </p>
            </div>
            <div class="card" id="invalid_wallet_address_message">
            </div>

            <table class="table table-responsive w-100 d-block d-md-table table-bordered" style="width: 100%">

                <thead>
                    <tr>
                        <th scope="col" colspan="2"></th>
                        <th scope="col" style="background: #e9fac8;color:black;text-align:center;">
                            &lt;25M
                        </th>
                        <th scope="col" style="background: #fff3bf;color:black;text-align:center;">
                            25M - 250M
                        </th>
                        <th scope="col" style="background: #d3f9d8;color:black;text-align:center;">
                            250M - 1B
                        </th>
                        <th scope="col" style="background: #ffd8a8;color:black;text-align:center;">
                            1B - 25B
                        </th>
                        <th scope="col" style="background: #ffa8a8;color:black;text-align:center;">
                            &gt;25B
                        </th>
                        <th style="text-align:center; border:none;" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            Risk
                            <div class="tooltip-container">
                                <span class="tooltip-icon"><i class="fa fa-info-circle"></i></span>
                                <div class="tooltip-content">Risk factor based on the range of market capitalization.
                                </div>
                            </div>

                        </td>
                        <td style="text-align:center;">
                            Very High
                        </td>
                        <td style="text-align:center;">
                            High
                        </td>
                        <td style="text-align:center;">
                            Medium
                        </td>
                        <td style="text-align:center;">
                            Low
                        </td>
                        <td style="text-align:center;">
                            Very Low
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid #ffffff;">Allocation%
                            <div class="tooltip-container">
                                <span class="tooltip-icon"><i class="fa fa-info-circle"></i></span>
                                <div class="tooltip-content">Risk factor % exposure for the portfolio analysis and
                                    adjustment.</div>
                            </div>
                        </td>
                        <td style="text-align: right">
                            <span id="total_allocation" class="ml-auto">100.0</span>
                        </td>
                        <form action="http://localhost:8000/change_allocation" method="POST"></form>
                        <input type="hidden" name="_token" value="irdfKsob986txSDHekgj3bBTYfsACLEHMPgjIzPS">
                        <input type="hidden" value="20" name="portfolio_id">
                        <input type="hidden" value="Original Portfolio" name="portfolio_name">
                        <td>
                            <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                20%
                            </div>
                            <input type="text" class="form-control hideBeforeedit hidden"
                                name="allocation_percentage[]" value="20">
                        </td>
                        <td>
                            <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                20%
                            </div>
                            <input type="text" class="form-control hideBeforeedit hidden"
                                name="allocation_percentage[]" value="20">
                        </td>
                        <td>
                            <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                20%
                            </div>
                            <input type="text" class="form-control hideBeforeedit hidden"
                                name="allocation_percentage[]" value="20">
                        </td>
                        <td>
                            <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                20%
                            </div>
                            <input type="text" class="form-control hideBeforeedit hidden"
                                name="allocation_percentage[]" value="20">
                        </td>
                        <td>
                            <div class="hideAfteredit allocation-percentage" style="text-align: center;">
                                20%
                            </div>
                            <input type="text" class="form-control hideBeforeedit hidden"
                                name="allocation_percentage[]" value="20">
                        </td>
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
                    </tr>
                    <tr>
                        <td colspan="2">
                            To Allocate $
                            <div class="tooltip-container">
                                <span class="tooltip-icon"><i class="fa fa-info-circle"></i></span>
                                <div class="tooltip-content">Total assets to allocate based on risk factor.</div>
                            </div>
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
                            <div class="tooltip-container">
                                <span class="tooltip-icon"><i class="fa fa-info-circle"></i></span>
                                <div class="tooltip-content">Total assets allocated.</div>
                            </div>
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
                            <div class="tooltip-container">
                                <span class="tooltip-icon"><i class="fa fa-info-circle"></i></span>
                                <div class="tooltip-content">Adjust the assets for the targeted risk factor.</div>
                            </div>
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
    <div class="modal fade" id="my_wallet_addresses" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card px-3 py-3 container card-custom" style="width: 100%">

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="kt_tab_pane_csv" role="tabpanel"
                                    aria-labelledby="kt_tab_pane_csv">
                                    <div class="card-body">
                                        <div id="wallet_address_collection">
                                            @foreach ($wallet_list as $wallet_address)
                                                <div class="input-group mb-3">
                                                    <input name="wallet_address[]" type="text"
                                                        class="form-control form-control-solid"
                                                        placeholder="Enter your wallet address" required
                                                        value="{{ $wallet_address }}" autocomplete="off" />
                                                    <button class="btn btn-icon btn-danger btn-sm mx-2" type="button"
                                                        onclick="removeWalletAddressField(this)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="btn btn-icon btn-info btn-sm mx-2" type="button"
                                            onclick="addWalletAddressField()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body" id="maximum_wallet_capacity_error_box">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold"
                                            id="modal-close-button" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary font-weight-bold"
                                            onclick="editWalletListModal()"
                                            id="coin-save-transaction-btn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
