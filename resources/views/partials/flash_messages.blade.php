@if(session()->has('flash_message_success'))
    <div class="grid-container">
        <div class="grid-x margin-grid-x align-center">
            <div class="cell medium-6 large-4">
                <ul class="flash-message flash-message-success">
                    <li><i aria-hidden="true" class="fas fa-thumbs-up"></i> {{ session()->get('flash_message_success') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if(session()->has('flash_message_error'))
    <div class="grid-container">
        <div class="grid-x margin-grid-x align-center">
            <div class="cell medium-6 large-4">
                <ul class="flash-message flash-message-error">
                    <li><i aria-hidden="true" class="fas fa-exclamation-triangle"></i> {{ session()->get('flash_message_error') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div class="grid-container">
        <div class="grid-x margin-grid-x align-center">
            <div class="cell medium-6 large-4">
                <ul class="flash-message flash-message-error">
                    @foreach($errors->all() as $error)
                        <li><i aria-hidden="true" class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session('status'))
    <div class="grid-container">
        <div class="grid-x margin-grid-x align-center">
            <div class="cell medium-6 large-4">
                <ul class="flash-message flash-message-success">
                    <li>{{ session('status') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endif
