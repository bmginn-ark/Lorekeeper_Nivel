<p>동일한 항목의 동일한 변형이 너무 많으신가요? 이 도구는 동일한 변형된 항목을 하나로 통합합니다.</p>
<p>다음 사항에 유의하시기 바랍니다:</p>
<ul>
    <li>This tool will go over all item stacks (variations) in your inventory. It does not include character inventories.</li>
    <li>Variations are considered identical if they have the same source and notes fields. These must be <i>exactly the same</i>.</li>
    <li>It cannot consolidate stacks that are partially held in trades and submissions.</li>
    <li>This operation is not reversible. You can, however, run it multiple times if necessary.</li>
</ul>
{!! Form::open(['url' => 'inventory/consolidate', 'class' => 'text-right']) !!}
{!! Form::submit('Consolidate', ['class' => 'btn btn-primary', 'name' => 'action']) !!}
{!! Form::close() !!}
