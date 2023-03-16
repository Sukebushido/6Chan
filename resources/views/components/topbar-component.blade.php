<div class="top-bar d-flex f-column">
    <div class="thread-border"></div>
    <div class="content">
        {!! $showReturn ? "<span>[<a href=".route('board', ['boardName' => $boardName]).">Return</a>]</span>" : "" !!}
        {!! $showCatalog ? "<span>[<a href=".route('catalog', ['boardName' => $boardName]).">Catalog</a>]</span>" : "" !!}
        {!! $showArchive ? "<span>[<a href=''>Archive</a>]</span>" : "" !!}
        {!! $showBottom ? "<span>[<a href=''>Bottom</a>]</span>" : "" !!}
        {!! $showUpdate ? "<span>[<a href=''>Update</a>]</span>" : "" !!}
        {!! $showRefresh ? "<span>[<a href=''>Refresh</a>]</span>" : "" !!}

    </div>
    <div class="thread-border"></div>
</div>
