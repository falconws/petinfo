<!DOCTYPE html>
<html lang="ja">

</html>

<head>
    <title>petinfo</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../static/css/pukiwiki.css">
</head>

<body>
    @foreach ($data_list as $data)
    <h3 id="content_1_0">
        {{ $data['Name'] }}
    </h3>

    <table class="style_table" cellspacing="1" border="0">
        <tbody>
            <tr>
                <th class="style_th">設定可能なペット</th>
                <td class="style_td" colspan="3"><img src="../static/img/mobheads/{{ $data['MobTypes'] }}.png" width="32" height="32"> {{ $data['MobTypesJp'] }}</td>
            </tr>
            <tr>
                <th class="style_th">説明</th>
                <td class="style_td" colspan="3">{{ $data['Description'] }}</td>
            </tr>
            <tr>
                <th class="style_th">最高レベル</th>
                <td class="style_td" colspan="3">{{ $data['MaxLevel'] }}</td>
            </tr>
            <tr>
                <th class="style_th">飛行</th>
                <td class="style_td" colspan="3">{{ $data['CanFly'] }}</td>
            </tr>
            <tr>
                <th class="style_th">バックパック</th>
                <td class="style_td" colspan="3">{{ $data['Backpack'] }}</td>
            </tr>
            <tr>
                <th class="style_th" rowspan="100">ビーコン</th>
                <td class="style_td" colspan="3">{{ $data['Beacon'] }}</td>
            </tr>
            @if ($data['Beacon'] == 'あり')
            <tr>
                <th class="style_th">効果</th>
                <th class="style_th">効果レベル</th>
                <th class="style_th">要求レベル</th>
            </tr>
            @endif
            @foreach ($data['Beacon_details'] as $beacon_detail)
                @foreach ($beacon_detail as $buff => $level)
                @php
                    $buff = explode('_', $buff);
                @endphp
            <tr>
                <td class="style_td" rowspan="{{ count($level) }}"><img src="../static/img/beacon/{{ strtolower($buff[0]) }}.png" width="32" height="32"> {{ $buff[1] }}</td>
                    @foreach ($level as $effect_level => $required_level)
                <td class="style_td">{{ $effect_level }}<span style="color:gray">
                </td>
                <td class="style_td">{{ $required_level }}</td>
                    @endforeach
            </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>

</html>