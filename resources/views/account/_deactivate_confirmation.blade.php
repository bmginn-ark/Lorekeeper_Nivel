@if (!Auth::user()->is_deactivated)
    <p>
        계정을 비활성화하시겠습니까? 모든 거래 및 제출이 취소되며 로그인 시 웹사이트에 액세스할 수 없습니다.
    </p>
    <div class="text-right"><a href="#" class="btn btn-danger deactivate-confirm-button">비활성화</a></div>

    <script>
        $('.deactivate-confirm-button').on('click', function(e) {
            e.preventDefault();
            $('#deactivateForm').submit();
        });
    </script>
@else
    <p>귀하의 계정은 이미 비활성화되어 있습니다.</p>
@endif
