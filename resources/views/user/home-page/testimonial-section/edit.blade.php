<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Testimonial') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="ajaxEditForm" class="modal-form" action="{{ route('user.home_page.update_testimonial') }}"
                      method="post" enctype="multipart/form-data">
                    
                    @csrf
                    <input type="hidden" id="inid" name="id">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-12 mb-2">
                                    <label for="image"><strong>{{ __('Image') . '*' }}</strong></label>
                                </div>
                                <div class="col-md-12 showImage mb-3">
                                    <img
                                        src=""
                                        alt="..."
                                        id="in_image"
                                        class="img-thumbnail">
                                </div>
                                <input type="file" name="image" id="image"
                                       class="form-control">
                                <p id="editErr_image" class="mt-1 mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Name') . '*' }}</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Client Name" id="inname">
                        <p id="editErr_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Occupation') . '*' }}</label>
                        <input type="text" class="form-control" name="occupation" placeholder="Enter Client Occupation"
                               id="inoccupation">
                        <p id="editErr_occupation" class="mt-1 mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Comment') . '*' }}</label>
                        <textarea class="form-control" name="comment" placeholder="Enter Client Comment" rows="5"
                                  id="incomment"></textarea>
                        <p id="editErr_comment" class="mt-1 mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Serial Number') . '*' }}</label>
                        <input type="number" class="form-control ltr" name="serial_number"
                               placeholder="Enter Serial Number" id="inserial_number">
                        <p id="editErr_serial_number" class="mt-1 mb-0 text-danger em"></p>
                        <p class="text-warning mt-2 mb-0">
                            <small>{{ __('The higher the serial number is, the later the testimonial will be shown.') }}</small>
                        </p>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    {{ __('Close') }}
                </button>
                <button id="updateBtn" type="button" class="btn btn-primary btn-sm">
                    {{ __('Update') }}
                </button>
            </div>
        </div>
    </div>
</div>
