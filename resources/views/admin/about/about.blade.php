@extends('layouts.dashboard')

@section('content')
    <section class="ps-profile__edit pt-5 pb-5">
        <div class="container">
            <div class="ps-profile-edit-inner-sec">
                <ul class="nav nav-tabs ps-profile__edit-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                            type="button" role="tab" aria-controls="about" aria-selected="true"><i
                                class="ri-account-circle-fill"></i> About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account"
                            type="button" role="tab" aria-controls="account" aria-selected="false"><i
                                class="ri-user-fill"></i> Account</button>
                    </li>
                </ul>

                @if (session('flash_success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('flash_success') }}
                    </div>
                @elseif(session('flash_error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('flash_error') }}
                    </div>
                @endif

                <div class="tab-content ps-tabs__content" id="myTabContent">
                    <div class="tab-pane ps-profile__edit-tab ps-profile__edit-tab--about fade show active" id="about"
                        role="tabpanel" aria-labelledby="about-tab">

                        <!-- ABOUT PROFILE SECTION DETAILS -->
                        <div class="ps-profile__progress ps-completeness-info ps-js-profile-completeness">
                            <div class="ps-profile__progress-message ps-completeness-status ps-js-status">
                                <a href="https://testlinks.xyz/dev1/john_fink/profile/admin/about">
                                    Your profile is {{ $percentage }}% complete</a>
                            </div>
                            <div class="ps-profile__progress-bar progress">
                                <div class="progress-bar w-{{ $percentage }}" role="progressbar"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="ps-profile__progress-required ps-missing-required-message">{{ $missingFields }}
                                required field(s) missing</div>
                        </div>

                        <form action="{{ route('user.updateAbout') }}" method="POST">
                            @csrf
                            <div class="ps-profile__about">
                                <div class="ps-profile__about-header d-flex align-items-center justify-content-between">
                                    <div class="ps-profile__about-header-title">
                                        Profile fields </div>

                                    <div class="ps-profile__about-header-actions ">
                                        <button class="ps-btn ps-btn--sm ps-btn--app ps-js-btn-edit-all"
                                            style="display: none;"><i class="gcis gci-user-edit"></i>Edit All</button>
                                        <input type="submit" value="Save All"
                                            class="ps-btn ps-btn ps-btn--sm ps-btn--action ps-js-btn-save-all">
                                    </div>
                                </div>
                            </div>

                            <!-- FIELDS -->
                            <div class="ps-profile__about-fields ">
                                <!-- FIELDS -->
                                <div class="ps-profile__about-fields ">

                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-title" id="field-title-99">
                                                    <span>First Name</span>
                                                    <span class="ps-profile__about-field-required">*</span>
                                                </div>
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-first-name">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit"
                                                        aria-label="Edit First Name" onclick="editFirstName(event)">
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form d-none"
                                                    id="action-buttons-first-name">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelEditFirstName(event)">
                                                        Cancel
                                                    </button>
                                                    <button class="ps-btn ps-btn--action ps-js-btn-save" role="button"
                                                        onclick="saveFirstName(event)">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-static ps-list-info-content-text"
                                            id="static-first-name">
                                            <div class="ps-profile__about-field-data ps-list-info-content-data"
                                                id="static-name-data">
                                                <span>{{ $user->first_name }}</span>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-form ps-list-info-content-form d-none"
                                            id="form-first-name">
                                            <div class="ps-input__wrapper" id="input-wrapper">
                                                <input class="ps-input ps-input--sm ps-input--count" type="text"
                                                    value="{{ $user->first_name }}" name="first_name" id="profile_field_99"
                                                    data-id="99">
                                            </div>
                                            @error('first_name')
                                                <div class="ps-form__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-title" id="field-title-100">
                                                    <span>Last Name</span>
                                                    <span class="ps-profile__about-field-required">*</span>
                                                </div>
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-last-name">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit"
                                                        aria-label="Edit Last Name" onclick="editLastName(event)">
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form d-none"
                                                    id="action-buttons-last-name">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelEditLastName(event)">
                                                        Cancel
                                                    </button>
                                                    <button class="ps-btn ps-btn--action ps-js-btn-save" role="button"
                                                        onclick="saveLastName(event)">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-static ps-list-info-content-text"
                                            id="static-last-name">
                                            <div class="ps-profile__about-field-data ps-list-info-content-data"
                                                id="static-last-name-data">
                                                <span>{{ $user->last_name }}</span>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-form ps-list-info-content-form d-none"
                                            id="form-last-name">
                                            <div class="ps-input__wrapper" id="last-name-wrapper">
                                                <input class="ps-input ps-input--sm ps-input--count" type="text"
                                                    value="{{ $user->last_name }}" name="last_name"
                                                    id="profile_field_100" data-id="100">
                                            </div>
                                            @error('last_name')
                                                <div class="ps-form__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-title" id="field-title-101">
                                                    <span>GENDER</span>
                                                    <span class="ps-profile__about-field-required">*</span>
                                                </div>
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-gender">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit"
                                                        aria-label="Edit Gender" onclick="editGender(event)">
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form d-none"
                                                    id="action-buttons-gender">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelEditGender(event)">
                                                        Cancel
                                                    </button>
                                                    <button class="ps-btn ps-btn--action ps-js-btn-save" role="button"
                                                        onclick="saveGender(event)">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-static ps-list-info-content-text"
                                            id="static-gender">
                                            <div class="ps-profile__about-field-data ps-list-info-content-data"
                                                id="static-gender-data">
                                                @if ($user->gender)
                                                    <span>{{ $user->gender }}</span>
                                                @else
                                                    <span
                                                        class="ps-profile__about-field-placeholder ps-text--danger">What's
                                                        your gender?</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-form ps-list-info-content-form d-none"
                                            id="form-gender">
                                            <div class="ps-input__wrapper" id="gender-wrapper">
                                                <select class="ps-input ps-input--sm form-select" name="gender"
                                                    id="profile_field_101" data-id="101">
                                                    <option value="male"
                                                        @if ($user->gender === 'male') selected @endif>Male</option>
                                                    <option value="female"
                                                        @if ($user->gender === 'female') selected @endif>Female</option>
                                                    <option value="other"
                                                        @if ($user->gender === 'other') selected @endif>Other</option>
                                                </select>
                                            </div>
                                            @error('gender')
                                                <div class="ps-form__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-title" id="field-title-102">
                                                    <span>BIRTHDATE</span>
                                                    <span class="ps-profile__about-field-required">*</span>
                                                </div>
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-birthdate">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit"
                                                        aria-label="Edit Birthdate" onclick="editBirthdate(event)">
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form d-none"
                                                    id="action-buttons-birthdate">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelEditBirthdate(event)">
                                                        Cancel
                                                    </button>
                                                    <button class="ps-btn ps-btn--action ps-js-btn-save" role="button"
                                                        onclick="saveBirthdate(event)">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-static ps-list-info-content-text"
                                            id="static-birthdate">
                                            <div class="ps-profile__about-field-data ps-list-info-content-data"
                                                id="static-birthdate-data">
                                                @if ($user->date_of_birth)
                                                    <span>{{ $user->date_of_birth }}</span>
                                                @else
                                                    <span class="ps-profile__about-field-placeholder ps-text--danger">When
                                                        were you born?</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-form ps-list-info-content-form d-none"
                                            id="form-birthdate">
                                            <div class="ps-input__wrapper" id="birthdate-wrapper">
                                                <input class="ps-input ps-input--sm ps-input--count" type="date"
                                                    value="{{ $user->date_of_birth }}" name="birthdate"
                                                    id="profile_field_102" data-id="102">
                                            </div>
                                            @error('birthdate')
                                                <div class="ps-form__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-title" id="field-title-103">
                                                    <span>ABOUT ME</span>
                                                    <span class="ps-profile__about-field-required">*</span>
                                                </div>
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-about-me">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit"
                                                        aria-label="Edit About Me" onclick="editAboutMe(event)">
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form d-none"
                                                    id="action-buttons-about-me">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelEditAboutMe(event)">
                                                        Cancel
                                                    </button>
                                                    <button class="ps-btn ps-btn--action ps-js-btn-save" role="button"
                                                        onclick="saveAboutMe(event)">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-static ps-list-info-content-text"
                                            id="static-about-me">
                                            <div class="ps-profile__about-field-data ps-list-info-content-data"
                                                id="static-about-me-data">
                                                @if ($user->about_me)
                                                    <span>{{ $user->about_me }}</span>
                                                @else
                                                    <span class="ps-profile__about-field-placeholder">Tell us something
                                                        about yourself.</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ps-profile__about-field-form ps-list-info-content-form d-none"
                                            id="form-about-me">
                                            <div class="ps-input__wrapper" id="about-me-wrapper">
                                                <textarea class="ps-input ps-input--sm ps-input--count form-control" name="about_me" id="profile_field_103"
                                                    data-id="103" placeholder="Tell us something about yourself.">{{ $user->about_me }}</textarea>
                                            </div>
                                            @error('about_me')
                                                <div class="ps-form__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- edit all button -->
                                    <div class="ps-profile__about-field">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-edit ps-list-info-content-text"
                                                    id="edit-all">
                                                    <button class="ps-btn ps-btn--app ps-btn-edit" aria-label="Edit All"
                                                        onclick="editAll(event)">
                                                        Edit All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- save all button -->
                                    <div class="ps-profile__about-field d-none" id="save-all-section">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form">
                                                    <button class="ps-btn ps-btn--app ps-btn-save" role="button"
                                                        onclick="saveAll(event)">
                                                        Save All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- cancel all button -->
                                    <div class="ps-profile__about-field d-none" id="cancel-all-section">
                                        <div class="ps-profile__about-field-row ps-list-info-content">
                                            <div class="ps-profile__about-field-header">
                                                <div class="ps-profile__about-field-actions ps-list-info-content-form">
                                                    <button class="ps-btn ps-btn--app ps-btn-cancel" role="button"
                                                        onclick="cancelAll(event)">
                                                        Cancel All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- ABOUT PROFILE SECTION DETAILS -->



















            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                <div class="ps-profile__account-row ps-profile__account--basic">
                    <div class="ps-profile__account-header">
                        Your Account
                    </div>
                    <div class="ps-profile__account-form">
                        <form name="profile-edit" id="profile-edit" action="{{ route('user.updateAccount') }}"
                            method="POST" class="ps-form community-form-validate" autocomplete="off">
                            @csrf
                            <div class="ps-form__grid">
                                <div class="ps-form__row">
                                    <label id="verify_passwordmsg" for="password"
                                        class="ps-form__label ps-input--sm ps-js-password-preview">
                                        Current Password
                                    </label>

                                    <div class="ps-form__field">
                                        <input type="password" name="password" id="password"
                                            class="ps-input ps-input--sm" autocomplete="off"
                                            title="Enter your current password to change your account information">
                                        <span id="toggleButton" onclick="togglePassword()" style="cursor: pointer;">Show
                                            Password</span>
                                        <div class="ps-form__field-desc lbl-descript">
                                            Enter your current password to change your account information
                                        </div>
                                    </div>

                                </div>
                                <div class="ps-form__row ps-form__row--user">
                                    <label id="first_name" for="first_name" class="ps-form__label">
                                        User Name
                                    </label>
                                    <div class="ps-form__field">
                                        <input type="text" name="first_name" id="first_name"
                                            class="ps-input username required maxlen:320 custom"
                                            value="{{ auth()->user()->first_name }}">
                                        <div class="ps-form__field-desc lbl-descript">If you change your username, you will
                                            be signed out</div>
                                    </div>
                                </div>
                                <div class="ps-form__row ps-form__row--email">
                                    <label id="user_emailmsg" for="email" class="ps-form__label">
                                        Email<span class="ps-form__required">&nbsp;*</span>
                                    </label>
                                    <div class="ps-form__field">
                                        <input type="text" name="email" id="email"
                                            class="ps-input email required maxlen:320 custom"
                                            value="{{ auth()->user()->email }}">
                                    </div>
                                </div>
                                <div class="ps-form__row ps-form__row--change-pass">
                                    <label id="change_passwordmsg" for="password"
                                        class="ps-form__label ps-password-preview">
                                        Change Password
                                    </label>
                                    <div class="ps-form__field">
                                        <input type="password" name="password" id="password" class="ps-input password"
                                            title="If you change your password, you will be signed out">
                                        <div class="ps-form__field-desc lbl-descript">If you change your password, you will
                                            be signed out</div>
                                        <span id="toggleChangePassword" onclick="toggleChangePassword()"
                                            style="cursor: pointer;">Show Password</span>
                                    </div>
                                </div>
                                <div class="ps-form__row ps-form__row--submit">
                                    <div class="ps-form__field">
                                        <input type="submit" name="submit" class="ps-btn ps-btn--sm ps-btn--action"
                                            value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>
    </section>


    <script>
        // first name
        function editFirstName(event) {
            event.preventDefault();
            document.getElementById('static-first-name').style.display = 'none';
            document.getElementById('form-first-name').classList.remove('d-none');
            document.getElementById('profile_field_99').value = document.getElementById('static-name-data').innerText
                .trim();
            document.getElementById('edit-first-name').classList.add('d-none');
            document.getElementById('action-buttons-first-name').classList.remove('d-none');
        }

        function cancelEditFirstName(event) {
            event.preventDefault();
            document.getElementById('static-first-name').style.display = 'block';
            document.getElementById('form-first-name').classList.add('d-none');
            document.getElementById('edit-first-name').classList.remove('d-none');
            document.getElementById('action-buttons-first-name').classList.add('d-none');
        }

        function saveFirstName(event) {
            event.preventDefault();
            var firstName = document.getElementById('profile_field_99').value;
            document.getElementById('static-name-data').innerHTML = '<span>' + firstName + '</span>';
            document.getElementById('static-first-name').style.display = 'block';
            document.getElementById('form-first-name').classList.add('d-none');
            document.getElementById('edit-first-name').classList.remove('d-none');
            document.getElementById('action-buttons-first-name').classList.add('d-none');
        }

        // last name
        function editLastName(event) {
            event.preventDefault();
            document.getElementById('static-last-name').style.display = 'none';
            document.getElementById('form-last-name').classList.remove('d-none');
            document.getElementById('profile_field_100').value = '';
            document.getElementById('edit-last-name').classList.add('d-none');
            document.getElementById('action-buttons-last-name').classList.remove('d-none');
        }

        function cancelEditLastName(event) {
            event.preventDefault();
            document.getElementById('static-last-name').style.display = 'block';
            document.getElementById('form-last-name').classList.add('d-none');
            document.getElementById('edit-last-name').classList.remove('d-none');
            document.getElementById('action-buttons-last-name').classList.add('d-none');
        }

        function saveLastName(event) {
            event.preventDefault();
            var lastName = document.getElementById('profile_field_100').value;
            document.getElementById('static-last-name-data').innerHTML = '<span>' + lastName + '</span>';
            document.getElementById('static-last-name').style.display = 'block';
            document.getElementById('form-last-name').classList.add('d-none');
            document.getElementById('edit-last-name').classList.remove('d-none');
            document.getElementById('action-buttons-last-name').classList.add('d-none');
        }

        // gender
        function editGender(event) {
            event.preventDefault();
            document.getElementById('static-gender').style.display = 'none';
            document.getElementById('form-gender').classList.remove('d-none');
            document.getElementById('edit-gender').classList.add('d-none');
            document.getElementById('action-buttons-gender').classList.remove('d-none');
        }

        function cancelEditGender(event) {
            event.preventDefault();
            document.getElementById('static-gender').style.display = 'block';
            document.getElementById('form-gender').classList.add('d-none');
            document.getElementById('edit-gender').classList.remove('d-none');
            document.getElementById('action-buttons-gender').classList.add('d-none');
        }

        function saveGender(event) {
            event.preventDefault();
            var gender = document.getElementById('profile_field_101');
            var selectedGender = gender.options[gender.selectedIndex].text;
            document.getElementById('static-gender-data').innerHTML = '<span>' + selectedGender + '</span>';
            document.getElementById('static-gender').style.display = 'block';
            document.getElementById('form-gender').classList.add('d-none');
            document.getElementById('edit-gender').classList.remove('d-none');
            document.getElementById('action-buttons-gender').classList.add('d-none');
        }

        // birthday
        function editBirthdate(event) {
            event.preventDefault();
            document.getElementById('static-birthdate').style.display = 'none';
            document.getElementById('form-birthdate').classList.remove('d-none');
            document.getElementById('profile_field_102').value = '';
            document.getElementById('edit-birthdate').classList.add('d-none');
            document.getElementById('action-buttons-birthdate').classList.remove('d-none');
        }

        function cancelEditBirthdate(event) {
            event.preventDefault();
            document.getElementById('static-birthdate').style.display = 'block';
            document.getElementById('form-birthdate').classList.add('d-none');
            document.getElementById('edit-birthdate').classList.remove('d-none');
            document.getElementById('action-buttons-birthdate').classList.add('d-none');
        }

        function saveBirthdate(event) {
            event.preventDefault()
            var birthdate = document.getElementById('profile_field_102').value;
            document.getElementById('static-birthdate-data').innerHTML = '<span>' + birthdate + '</span>';
            document.getElementById('static-birthdate').style.display = 'block';
            document.getElementById('form-birthdate').classList.add('d-none');
            document.getElementById('edit-birthdate').classList.remove('d-none');
            document.getElementById('action-buttons-birthdate').classList.add('d-none');
        }

        // about me
        function editAboutMe(event) {
            event.preventDefault();
            document.getElementById('static-about-me').style.display = 'none';
            document.getElementById('form-about-me').classList.remove('d-none');
            document.getElementById('profile_field_103').value = '';
            document.getElementById('edit-about-me').classList.add('d-none');
            document.getElementById('action-buttons-about-me').classList.remove('d-none');
        }

        function cancelEditAboutMe(event) {
            event.preventDefault();
            document.getElementById('static-about-me').style.display = 'block';
            document.getElementById('form-about-me').classList.add('d-none');
            document.getElementById('edit-about-me').classList.remove('d-none');
            document.getElementById('action-buttons-about-me').classList.add('d-none');
        }

        function saveAboutMe(event) {
            event.preventDefault();
            var aboutMe = document.getElementById('profile_field_103').value;
            document.getElementById('static-about-me-data').innerHTML = '<span>' + aboutMe + '</span>';
            document.getElementById('static-about-me').style.display = 'block';
            document.getElementById('form-about-me').classList.add('d-none');
            document.getElementById('edit-about-me').classList.remove('d-none');
            document.getElementById('action-buttons-about-me').classList.add('d-none');
        }

        // edit all
        function editAll(event) {
            event.preventDefault();
            editFirstName(event);
            editLastName(event);
            editGender(event);
            editBirthdate(event);
            editAboutMe(event);

            document.getElementById('edit-all').classList.add('d-none');
            document.getElementById('save-all-section').classList.remove('d-none');
            document.getElementById('cancel-all-section').classList.remove('d-none');
        }

        // cancel all
        function cancelAll(event) {
            event.preventDefault();
            cancelEditFirstName();
            cancelEditLastName();
            cancelEditGender();
            cancelEditBirthdate();
            cancelEditAboutMe();

            document.getElementById('edit-all').classList.remove('d-none');
            document.getElementById('save-all-section').classList.add('d-none');
            document.getElementById('cancel-all-section').classList.add('d-none');
        }

        // save all
        function saveAll(event) {
            event.preventDefault();
            saveFirstName();
            saveLastName();
            saveGender();
            saveBirthdate();
            saveAboutMe();

            document.getElementById('edit-all').classList.remove('d-none');
            document.getElementById('save-all-section').classList.add('d-none');
            document.getElementById('cancel-all-section').classList.add('d-none');
        }

        // show password
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleButton = document.getElementById("toggleButton");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide Password";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show Password";
            }
        }

        // show change password field
        function toggleChangePassword() {
            var changePasswordField = document.getElementById("change_password");
            var toggleChangePasswordButton = document.getElementById("toggleChangePassword");
            if (changePasswordField.type === "password") {
                changePasswordField.type = "text";
                toggleChangePasswordButton.textContent = "Hide Password";
            } else {
                changePasswordField.type = "password";
                toggleChangePasswordButton.textContent = "Show Password";
            }
        }

        // Clear the first password field on page load
        window.onload = function() {
            var firstPasswordField = document.getElementById("password");
            firstPasswordField.value = "";
        };
    </script>
@endsection
