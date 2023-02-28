<?php
/**
 * @var Danshin\Comment\Models\Report $report 
 */
?>

<div>
    <p>{{ $report->date }}</p>
    <p>{{ $report->title }}</p>
    @foreach ($report->content as $item)
        <div>
            @php
                $array = explode("\n", $item);
                $count = count($array);
                for ($i = 0; $i < $count; $i++) {
                    if (str_contains($array[$i], "message -")) {
                        echo '<div style="font-weight: bold">' . $array[$i] . "</div>";
                    } else {
                        echo '<div style="color: cadetblue">' . $array[$i] . "</div>";
                    }
                }
            @endphp
            <br />
            <div style="color: cadetblue">#######################</div>
            <br />
        </div>
    @endforeach
</div>