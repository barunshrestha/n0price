<div class="modal fade" id="new_portfolio_modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Portfolio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="window.location.reload();">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('portfolio.store') }}" method="POST">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-root">
                                <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">
                                    <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">
                                        <div class="login-form text-center position-relative overflow-hidden">
                                            <div class="login-signin">
                                                <div class="form-group mb-5 text-left">
                                                    <span>
                                                        Please define your portfolio name.
                                                    </span>
                                                    <input
                                                        class="form-control h-auto form-control-solid py-4 px-8 @error('portfolio_name')is-invalid @enderror"
                                                        type="text" placeholder="Portfolio Name" required
                                                        name="portfolio_name" />
                                                    @error('portfolio_name')
                                                        <div class="d-flex mt-2 invalid-feedback">
                                                            <i class="text-danger flaticon2-information"
                                                                data-dismiss="alert"></i>
                                                            <div class="text-danger mx-3"> {{ $message }}</div>
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div>
                                                    @csrf
                                                    Please define your portfolio risk level.<b> You
                                                        can change
                                                        this later.</b>
                                                    <table class="table mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Market Capital</th>
                                                                <th scope="col">Risk</th>
                                                                <th scope="col">Allocation %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr style="background:#e9fac8;">
                                                                <td style="vertical-align: middle;">
                                                                    <25M </td>
                                                                <td style="vertical-align: middle;">Very High
                                                                </td>
                                                                <td style="vertical-align: middle;"><input
                                                                        type="text" class="form-control"
                                                                        name="allocation_percentage[]" value="0">
                                                                </td>
                                                            </tr>
                                                            <tr style="background:#fff3bf;">
                                                                <td style="vertical-align: middle;">
                                                                    25M - 250M</td>
                                                                <td style="vertical-align: middle;">High
                                                                </td>
                                                                <td style="vertical-align: middle;"><input
                                                                        type="text" class="form-control"
                                                                        name="allocation_percentage[]" value="0">
                                                                </td>
                                                            </tr>
                                                            <tr style="background:#d3f9d8;">
                                                                <td style="vertical-align: middle;">
                                                                    250M - 1B	</td>
                                                                <td style="vertical-align: middle;">Medium
                                                                </td>
                                                                <td style="vertical-align: middle;"><input
                                                                        type="text" class="form-control"
                                                                        name="allocation_percentage[]" value="0">
                                                                </td>
                                                            </tr>
                                                            <tr style="background:#ffd8a8;">
                                                                <td style="vertical-align: middle;">
                                                                    1B - 25B	</td>
                                                                <td style="vertical-align: middle;">Low
                                                                </td>
                                                                <td style="vertical-align: middle;"><input
                                                                        type="text" class="form-control"
                                                                        name="allocation_percentage[]" value="0">
                                                                </td>
                                                            </tr>
                                                            <tr style="background:#ffa8a8;">
                                                                <td style="vertical-align: middle;">
                                                                    >25B	</td>
                                                                <td style="vertical-align: middle;">Very Low	
                                                                </td>
                                                                <td style="vertical-align: middle;"><input
                                                                        type="text" class="form-control"
                                                                        name="allocation_percentage[]" value="0">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
