<div class="card card-flush ">
    <div class="card-body pt-0">
        <div class="table-responsive">
           @include('vendor.abnermouke.console.builder.table.km8.subs', compact('sign', 'data', 'checkbox', 'fields', 'default_show_fields', 'actions', 'sub_query_url', 'signature', 'column_count'))
        </div>
    </div>
    @include('vendor.abnermouke.console.builder.table.km8.pagination', array_merge($data, compact('sign')))
</div>
