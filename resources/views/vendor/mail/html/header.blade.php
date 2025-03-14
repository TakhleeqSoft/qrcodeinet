@props(['url'])
<tr class="headerTr">
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset(config('app.dark_sm_logo')) }}" style="width: 260px !important;height: 60px !important;" class="logo" alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>
