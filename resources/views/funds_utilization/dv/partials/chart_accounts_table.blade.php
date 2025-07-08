@foreach ($dvAccounts as $dvAccount)  
  @php
    $hasBIR = stripos($dvAccount->chartAccount->name, 'BIR') !== false;
    $isMDS = stripos($dvAccount->chartAccount->name, 'MDS') !== false;

    $rsRow = $rsRow ?? $dvAccount->dvRsNet ?? null;

    $tax_one = $rsRow->tax_one ?? 0;
    $tax_two = $rsRow->tax_two ?? 0;
    $tax_twob = $rsRow->tax_twob ?? 0;
    $tax_three = $rsRow->tax_three ?? 0;
    $tax_five = $rsRow->tax_five ?? 0;
    $tax_six = $rsRow->tax_six ?? 0;
    $wtax = $rsRow->wtax ?? 0;
    $other_tax = $rsRow->other_tax ?? 0;

    $net_amount = $rsRow->net_amount ?? 0;

    $isReadOnly = $isMDS || $hasBIR;
    $inputStyle = $isReadOnly ? 'background-color:#e0e0e0;' : '';

    $birAmount = $tax_one + $tax_two + $tax_twob + $tax_three + $tax_five + $tax_six + $wtax + $other_tax;

    $totalAmount = $isMDS
        ? $net_amount
        : ($hasBIR ? $birAmount : ($dvAccount->amount ?? 0));
  @endphp

  <tr class="chart-accounts-row" data-dv-rs-id="{{ $rsRow->id }}">
    <td class="text-left">
      {{ $dvAccount->chartAccount->name }}
      <input type="hidden" name="dv_account_id[{{ $rsRow->id }}][]" value="{{ $dvAccount->id }}">
      <input type="hidden" class="account-title" value="{{ $dvAccount->chartAccount->name }}">
    </td>


    @foreach (['tax_one', 'tax_two', 'tax_twob', 'tax_three', 'tax_five', 'tax_six', 'wtax', 'other_tax'] as $taxField)
      @php 
        // $value = $hasBIR ? ${$taxField} : 0; 
        $value = $hasBIR ? ${$taxField} : '';
        // $inputValue = $hasBIR ? old($taxField.'.'.$rsRow->id, $value) : $value;
         $inputValue = old($taxField.'.'.$rsRow->id.'.'.$dvAccount->id, $value);
      @endphp
      {{-- Tax fields if Account Title with B--}}
      <td style="min-width:6%; max-width:8%;">
        <input type="text"
          size="7"
          class="text-right amount tax"
          id="{{ $taxField }}_{{ $rsRow->id }}"
          name="{{ $taxField }}[{{ $rsRow->id }}][{{ $dvAccount->id }}]"
          style="{{ !$hasBIR ? 'background-color:#e0e0e0;' : '' }}"
          {{-- value="{{ number_format($value, 2) }}" --}}
          value="{{ is_numeric($value) ? number_format($value, 2) : '' }}"
          {{ !$hasBIR ? 'readonly' : '' }}>
      </td> 
    @endforeach

    <td colspan="2" style="min-width:8%; max-width:8%;">
      @if ($hasBIR)
        {{-- BIR amount --}}
        <span class="text-right d-block chart-amount-display">{{ number_format($birAmount, 2) }}</span>
        <input type="hidden"
          name="amount[{{ $rsRow->id }}][]"
          class="chart-amount-hidden"
          value="{{ $birAmount }}"
          data-dv-rs-id="{{ $rsRow->id }}">
      @elseif ($isMDS) 
        {{-- MDS amount --}}
        <span class="text-right d-block chart-amount-display">{{ number_format($net_amount, 2) }}</span>
        <input type="hidden"
          name="amount[{{ $rsRow->id }}][]"
          class="chart-amount-hidden"
          value="{{ number_format($net_amount, 2) }}"
          data-mds="1"
          data-dv-rs-id="{{ $rsRow->id }}">
      @else
        {{-- Other amount --}}
        <input type="text"
          size="7"
          class="text-right amount"
          id="amount_{{ $dvAccount->id }}"
          name="amount[{{ $rsRow->id }}][]"
          value="{{ number_format($totalAmount, 2) }}"
          data-dv-rs-id="{{ $rsRow->id }}">
      @endif
    </td>

    <td class="text-center">
      <button type="button"
        class="btn-xs btn_delete_dv_chart_account btn btn-outline-danger"
        data-id="{{ $dvAccount->id }}"
        data-toggle="tooltip"
        data-placement="auto"
        title="Delete DV chart of account">
        <i class="fa-solid fa-trash"></i>
      </button>
    </td>
  </tr>
@endforeach
