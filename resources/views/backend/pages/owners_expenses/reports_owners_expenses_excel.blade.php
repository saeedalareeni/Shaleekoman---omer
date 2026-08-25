<table style="text-align: center; width: 100%;">
    <tr>
        <th colspan="6" style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 500px; ">
            {{trans('back.reports_owners_expenses')}}
            {{trans('back.from_date')}} :
            {{request()->start_date}}
            -
            {{trans('back.to_date')}} :
            {{request()->end_date}}
        </th>
    </tr>
</table>
<table class="text-center">
    <thead>
    <tr>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">#</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{trans('back.owner')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{trans('back.amount')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{trans('back.expense_date')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{trans('back.Created_at')}}</th>
        <th style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{trans('back.User')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($owners_expenses as $key => $owners_expense)
        <tr>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 25px;">{{$key+1}}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $owners_expense->Owner->name ?? '' }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $owners_expense->amount }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $owners_expense->expense_date }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $owners_expense->created_at }}</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{ $owners_expense->User->name ?? "" }}</td>

        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 50px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;">{{number_format($total_amount, 3)}}</td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
        <td style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 100px;"></td>
    </tr>
    </tfoot>
</table>
