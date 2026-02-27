<div class="rounded shadow-sm">
    <input type="hidden" name="player-select" id="player-select" value="{{ $player->id }}">
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <div class="col-12 col-md-4 py-4">
            <h2 class="text-2xl font-bold text-white mb-6">{{ __('messages.Информация о игроке') }}</h2>
            <div id="info_player"></div>
        </div>
        <div class="col-12 col-md-6 py-4">
            <canvas id="myChart" style="width: 100% !important;"></canvas>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3">
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_weight"></canvas>
        </div>
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_height"></canvas>
        </div>
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_step"></canvas>
        </div>
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_push_ups"></canvas>
        </div>
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_pull_ups"></canvas>
        </div>
        <div class="col-12 col-md-4 py-4">
            <canvas id="info_long_jump"></canvas>
        </div>
    </div>
</div>
