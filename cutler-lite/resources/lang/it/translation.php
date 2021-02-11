<?php

return \App\Models\LanguageSetting::get()->pluck('it', 'key');
