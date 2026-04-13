@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
<div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8a2be2, #6a0dad); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
    <span style="font-size: 28px; line-height: 60px; display: block; text-align: center; width: 60px;">🐾</span>
</div>
<span style="font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 24px; font-weight: 700; color: #8a2be2; letter-spacing: 1px;">{{ $slot }}</span>
</a>
</td>
</tr>
