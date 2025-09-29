<div class="p-4">
    <form id="filterForm" class="mb-4 flex gap-2 items-center">
        <input type="hidden" name="team_code" value="{{ $teamCode }}">
        <input type="month" name="month" value="{{ $month }}" class="border rounded px-2 py-1">
    </form>

    <div id="calendarContainer" class="overflow-auto">
        @include('attendance._calendar_table', ['users' => $users, 'days' => $days, 'presences' => $presences])
    </div>
</div>

<script>
    // When month changes, send AJAX request
    document.querySelector('input[name="month"]').addEventListener('change', function () {
        let formData = new FormData(document.getElementById('filterForm'));
        let params = new URLSearchParams(formData).toString();

        fetch("{{ route('attendance.calendar') }}?" + params, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.text())
            .then(html => {
                document.getElementById('calendarContainer').innerHTML = html;
            });
    });
</script>
