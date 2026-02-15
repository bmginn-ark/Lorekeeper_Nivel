@if (!$user->is_banned)
    <p>{{ __('Are you sure you want to ban :name?', ['name' => $user->name]) }}</p>
    <div class="text-right"><a href="#" class="btn btn-danger ban-confirm-button">{{ __('Ban') }}</a></div>

    <script>
        $('.ban-confirm-button').on('click', function(e) {
            e.preventDefault();
            $('#banForm').submit();
        });
    </script>
@else
    <p>{{ __('This user is already banned.') }}</p>
@endif
