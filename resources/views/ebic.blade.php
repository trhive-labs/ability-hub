@inject('content', 'App\Repositories\EBICDataRepository')

<style>
    .rotate {

        transform: rotate(-90deg);


        /* Legacy vendor prefixes that you probably don't need... */

        /* Safari */
        -webkit-transform: rotate(-90deg);

        /* Firefox */
        -moz-transform: rotate(-90deg);

        /* IE */
        -ms-transform: rotate(-90deg);

        /* Opera */
        -o-transform: rotate(-90deg);

        /* Internet Explorer */
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);

    }
</style>


<table class="table-auto">
    <thead>
    <tr>
        @foreach($content->data['categories'] as $category)
            <th>{{ $category['name'][config('app.locale')] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php
        $tableContent = $content->getTableContent();
    @endphp
    @foreach($tableContent as $index => $row)
        <tr data-order="{{ $row['order'] }}">
            @foreach($row['cells'] as $cell)
                @php
                    $color = "#ffffff";
                    if (array_key_exists('content', $cell)) {
                      switch($cell['content']['level']) {
                          case "advanced":
                              $color = "#ffffff";
                              break;
                          case "intermediate":
                              $color = "#dddddd";
                              break;
                          case "initial":
                              $color = "#aaaaaa";
                              break;
                      }
                  }

                @endphp
                <td id="{{$cell['type'] === 'filled' ? $cell['content']['id'] : 'empty-'.$cell['xCoordinate'].'-'.$cell['yCoordinate']}}"
                    data-original-color="{{ $color }}"
                    data-type="{{ $cell['type'] }}"
                    class="text-xs text-center border"
                    style="background-color: {{ $color }}"
                    colspan="{{ $cell['colspan'] }}" rowspan="{{ $cell['rowspan'] }}">
                    @if($cell['type'] === 'filled')
                        <p title="{{$cell['content']['name'][config('app.locale')]}}">
                            {{$cell['content']['name'][config('app.locale')]}}
                        </p>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <thead>
    <tr>
        @foreach($content->data['categories'] as $category)
            <th>{{ $category['name'][config('app.locale')] }}</th>
        @endforeach
    </tr>
    </thead>
</table>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var cells = document.querySelectorAll("td");
        cells.forEach(function(cell) {
            if (cell.getAttribute('data-type') === 'filled') {
                cell.addEventListener("click", function () {
                    // Se la cella è già verde (verifica sia "green" che il valore rgb corrispondente)
                    if (this.style.backgroundColor === "green" || this.style.backgroundColor === "rgb(0, 128, 0)") {
                        this.style.backgroundColor = this.getAttribute("data-original-color");
                    } else {
                        this.style.backgroundColor = "green";
                    }
                });
            }
        });
    });
</script>

