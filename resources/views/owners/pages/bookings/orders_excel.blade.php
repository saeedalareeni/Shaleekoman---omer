<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="12" style="text-align: center; vertical-align: middle">
            {{trans('back.booking_customers')}}
          </th>
    </tr>
</table>

<table style="text-align: center; vertical-align: middle">
    <thead>
        <tr>
            <th style="text-align: center; vertical-align: middle"> #</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.chalet_name')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.booking_number')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.customer_name')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.phone')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.email')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.days_number')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.days')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.payment_method')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.Total_amount')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.amount_paid')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.rest_amount')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.Status')}}</th>
            <th style="text-align: center; vertical-align: middle">{{trans('back.Created_at')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $key => $order)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$loop->iteration}}</td>
            <td style="text-align: center; vertical-align: middle"> {{ app()->getLocale() == 'ar' ? $order->chalet->chalet_name_ar : $order->chalet->chalet_name_en }}</td>
            <td style="text-align: center; vertical-align: middle">{{$order->booking_number}}</td>
            <td style="text-align: center; vertical-align: middle"> {{ $order->customer_name ?? '--' }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $order->phone_number ??'--' }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $order->email ??'--' }}</td>
            <td style="text-align: center; vertical-align: middle"><span>{{ $order->dates->count()}}</span> {{ $order->booking_type }}</td>
            <td style="text-align: center; vertical-align: middle">
                @foreach ($order->dates as $date)
                    <span class=" border-2 bg-blue" style='line-height: 17px'>
                        {{ $date->date}}
                    </span>
                @endforeach
            </td>
            <td style="text-align: center; vertical-align: middle"> {{ $order->PaymentMethod->name}}{{app()->getLocale() == 'ar' ? $order->PaymentMethod->name_ar : $order->PaymentMethod->name_en}}</td>
            <td style="text-align: center; vertical-align: middle"> {{ $order->total_amount }}</td>
            <td style="text-align: center; vertical-align: middle"> {{ $order->payment_amount }}</td>
            <td style="text-align: center; vertical-align: middle"> {{  $order->total_amount - $order->payment_amount}}</td>
            <td style="text-align: center; vertical-align: middle">{{ trans("back.$order->payment_status")}}</td>
            <td style="text-align: center; vertical-align: middle">{{$order->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
