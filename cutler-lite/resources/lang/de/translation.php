<?php

return \App\Models\LanguageSetting::get()->pluck('de', 'key');
