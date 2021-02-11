<?php

return \App\Models\LanguageSetting::get()->pluck('tr', 'key');
