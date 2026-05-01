<!-- PopOut Add Patient Modal -->
<div class="modal fade" id="modal-add-patient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a new patient</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="needs-validation" method="post" action="{{ route('patients.store') }}" novalidate>
                        @csrf
                        @if (\App\Enums\UserRoles::isDoctor(Auth::user()->role) || \App\Enums\UserRoles::isAdmin(Auth::user()->role))
                            <input type="number" name="doctor_id" value="{{ Auth::user()->id }}" hidden>
                        @endif

                        <!-- Name -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="model-field__control">
                                        <input id="name" name="name" type="text"
                                            class="@error('name') error-border @enderror model-field__input form-control"
                                            value="{{ old('name') }}" placeholder=" " required />
                                        <label for="name" class="model-field__label">Name</label>
                                        <div class="model-field__bar"></div>
                                        @error('name')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lastname -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="model-field__control">
                                        <input id="lastname" name="lastname" type="text"
                                            class="@error('lastname') error-border @enderror model-field__input form-control"
                                            value="{{ old('lastname') }}" placeholder=" " required />
                                        <label for="lastname" class="model-field__label">Last Name</label>
                                        <div class="model-field__bar"></div>
                                        @error('lastname')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Security Number -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="model-field__control">
                                        <input id="noSSocial" name="noSSocial" type="number"
                                            class="@error('noSSocial') error-border @enderror model-field__input form-control"
                                            value="{{ old('noSSocial') }}" placeholder=" " required />
                                        <label for="noSSocial" class="model-field__label">Social Security Number</label>
                                        <div class="model-field__bar"></div>
                                        @error('noSSocial')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="model-field__control">
                                        <input id="username" name="username" type="text"
                                            class="@error('username') error-border @enderror model-field__input form-control"
                                            value="{{ old('username') }}" placeholder=" " required />
                                        <label for="username" class="model-field__label">Username</label>
                                        <div class="model-field__bar"></div>
                                        @error('username')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="model-field__control">
                                        <input id="email" name="email" type="email"
                                            class="@error('email') error-border @enderror model-field__input form-control"
                                            value="{{ old('email') }}" placeholder=" " required />
                                        <label for="email" class="model-field__label">Email</label>
                                        <div class="model-field__bar"></div>
                                        @error('email')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="input-group">
                                        <input type="text" id="phone" name="phone"
                                            class="@error('phone') error-border @enderror form-control"
                                            data-inputmask="'mask': ['99-99-99-99-99 [x99999]', '+099 99 99 9999[9]-9999']"
                                            data-mask required />
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="row">
                            <div class="col-sm">
                                <div class="model-field">
                                    <div class="input-group date" id="dob" name="dob" data-target-input="nearest">
                                        <input type="date" name="dob" class="form-control"
                                            data-target="#dob" placeholder="Date of Birth" required />
                                        <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer buttons -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
