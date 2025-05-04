TextColumn::make('TotalPrice')
    ->label(__('Price'))
    ->formatStateUsing(function ($state) {
        // تحويل القيمة إلى رقم
        $amount = floatval($state);
        // تنسيق الرقم
        $formatted = number_format($amount, 2);
        // إرجاع النص مع الرمز
        return $formatted . ' <span class="icon-saudi_riyal"></span>';
    })
    ->html()
    ->disableClick()
    ->toggleable(isToggledHiddenByDefault: false) 