@if (!$user->is_deactivated)
    <p>{{ __('Are you sure you want to deactivate :name?', ['name' => $user->name]) }}</p>
    <div class="text-right"><a href="#" class="btn btn-danger deactivate-confirm-button">{{ __('Deactivate') }}</a></div>

    <script>
        $('.deactivate-confirm-button').on('click', function(e) {
            e.preventDefault();
            $('#deactivateForm').submit();
        });
    </script>
@else
    <p>{{ __('This user is already deactivated.') }}</p>
@endif
