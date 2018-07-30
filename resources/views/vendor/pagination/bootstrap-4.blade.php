@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" id="prevpage" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link pagenumber" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" id='nextpage' href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
<script>
$('#prevpage').on('click',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
		type	: "GET",
		url		: $(this).attr('href'),
        success	: function(html) {					
                    $("#main_panel").html(html).show('slow');
                },
                error : function (jqXHR, textStatus, errorThrown) {							
                        window.location.href = '/1_atms/public/login';
                } //end function
    });//close ajax
});
$('#nextpage').on('click',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
		type	: "GET",
		url		: $(this).attr('href'),
        success	: function(html) {					
                    $("#main_panel").html(html).show('slow');
                },
                error : function (jqXHR, textStatus, errorThrown) {							
                        window.location.href = '/1_atms/public/login';
                } //end function
    });//close ajax
});
$('.pagenumber').on('click',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
		type	: "GET",
		url		: $(this).attr('href'),
        success	: function(html) {					
                    $("#main_panel").html(html).show('slow');
                },
                error : function (jqXHR, textStatus, errorThrown) {							
                        window.location.href = '/1_atms/public/login';
                } //end function
    });//close ajax
});
</script>
