<style>
    .pagination{
        margin: 0;
    }
</style>

<div class="panel-footer">
    <div class="row">
        <div class="col-lg-4">
            <ul class="pagination">
                <li class="disabled"><span>{{ trans('rinvex/fort::backend/forms.common.pages', ['count' => $resource->count(), 'total' => $resource->total()]) }}</span></li>
            </ul>
        </div>
        <div class="col-lg-8 text-right">
            {{ $resource->links() }}
        </div>
    </div>
</div>
