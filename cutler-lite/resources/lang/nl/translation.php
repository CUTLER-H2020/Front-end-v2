<?php

return \App\Models\LanguageSetting::get()->pluck('nl', 'key');
