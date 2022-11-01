<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 mt-5 pb-0">
        <div class="card-title">
            <h3 class="card-label">My Portfolios
                {{-- <span class="d-block text-muted pt-2 font-size-sm">List of available Portfolio</span> --}}
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="mt-10">
                <button type="button" class="btn btn-primary mx-auto my-3" data-toggle="modal"
                    data-target="#new_portfolio_modal">
                    <i class="flaticon2-plus"></i>
                    Portfolio</button>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..."
                                    id="kt_datatable_my_portfolio_search" />
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <table class="datatable datatable-bordered table-responsive" id="kt_datatable_my_portfolio">
            <thead>
                <th>PORTFOLIO</th>
                <th>ACTIVE</th>
                <th>ACTIONS</th>
            </thead>
            <tbody>
                @foreach ($portfolios as $portfolio)
                    <tr>
                        <td>
                            <div id="myportfolio_name-{{ $portfolio->id }}">
                                <div class="hide_after_edit">
                                    {{ $portfolio->portfolio_name ? $portfolio->portfolio_name : 'Name unavailable' }}
                                </div>

                                <input type="text" name="portfolio_name"
                                    class="form-control hidden  hide_before_edit" style="width: 85%;"
                                    value="{{ $portfolio->portfolio_name }}">
                            </div>
                        </td>
                        <td><?php
                        if ($portfolio->id == $selected_portfolio->portfolio_id) {
                            echo "<i class='flaticon2-correct text-success'></i>";
                        }
                        ?></td>
                        <td>

                            <div id="myportfolio_action_buttons-{{ $portfolio->id }}">
                                <div class="hide_after_edit">
                                    @if ($portfolio->id == $selected_portfolio->portfolio_id)
                                    @else
                                        <a href="{{ route('portfolio.active', $portfolio->id) }}"
                                            class="btn btn-icon btn-info btn-xs mr-2" data-toggle="tooltip"
                                            title="Approve">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <button class="btn btn-icon btn-success btn-xs mr-2 myportfolioEditBtn"
                                        data-toggle="tooltip" title="Edit" id="myportfolioEdit-{{ $portfolio->id }}"
                                        onclick="myportfolioEditBtn(event)">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <form action="{{ route('portfolio.destroy', $portfolio->id) }}"
                                        style="display: inline-block;" method="post">
                                        {{ method_field('POST') }}
                                        {{ csrf_field() }}
                                        <button type="submit" value="Delete"
                                            class="btn btn-icon btn-danger btn-xs mr-2 deleteBtn" data-toggle="tooltip"
                                            title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                                <div class="hide_before_edit hidden d-flex justify-content-center">
                                    <button type="button" value="Save" class="btn btn-icon btn-success btn-xs mr-2"
                                        data-toggle="tooltip" title="Save"
                                        id="myportfolio_save_btn-{{ $portfolio->id }}"
                                        onclick="myportfoliosaveBtn(event)"><i
                                            class="flaticon2-check-mark"></i></button>

                                    <button type="button" value="Discard" onclick="myportfolioDiscardBtn(event)"
                                        id="myportfolioDiscard-{{ $portfolio->id }}"
                                        class="btn btn-icon btn-danger btn-xs mr-2" data-toggle="tooltip"
                                        title="Discard"><i class="flaticon2-cross"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
