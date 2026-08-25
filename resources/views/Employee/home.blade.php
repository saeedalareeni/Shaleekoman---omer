@extends('backend.layouts.master_employee')

@section('pageTitle')
{{trans('back.dashboard')}}
@endsection

@section('page_title')
{{trans('back.dashboard')}}
@endsection

@section('css')
    <style>
        .card_custom{
            padding: 5px;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <img src="{{asset($employee->image)}}"
                         class="rounded-circle avatar-xl img-thumbnail float-left mr-3" alt="profile-image">

                    <div class="profile-info-detail overflow-hidden">
                        <h4 class="mb-2">
                            <span class="text-danger">{{trans('back.employee_name')}} :</span>
                            @if (app()->getLocale() == 'ar')
                                {{ $employee->name_ar }}
                            @else
                                {{ $employee->name_en }}
                            @endif
                        </h4>
                        <p class="font-16">
                            <span class="text-danger">{{trans('back.employee_no')}} :</span>
                            {{$employee->employee_no}}
                        </p>

                        <p class="font-16">
                            <b>{{trans('back.Nationality')}} :</b>
                            {{$employee->Nationality}}
                            -
                            <b> {{trans('back.phone')}} :</b>
                            {{$employee->phone}}
                            -
                            <b>{{trans('back.email')}} :</b>
                            {{$employee->email}}
                            -
                            <b> {{trans('back.id_number')}} :</b>
                            {{$employee->id_number}}
                            -
                            <b> {{trans('back.passport_number')}} :</b>
                            {{$employee->passport_number}}
                            -
                            <b> {{trans('back.address')}} :</b>
                            {{$employee->address}}
                        </p>

                        <p class="font-16">
                            <b>{{trans('back.Total_Leave_Balance')}}</b>
                            <span class="text-danger">( {{$employee->Balances->sum('number')}} ) </span>
                            <br>

                            <b>{{trans('back.total_holidays')}}</b>
                            <span class="text-danger"> ( {{$employee->Holidays->sum('number')}} ) </span>
                            <br>

                            <b>{{trans('back.The_rest')}}</b>
                            <span class="text-danger">( {{$employee->Balances->sum('number') - $employee->Holidays->sum('number')}} ) </span>

                        </p>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <!--/ meta -->

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.Contracts')}} : </h4>
                @if(!$employee->Contracts->count() == 0)
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.contract_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.start_date')}}</th>
                                    <th> {{trans('back.end_date')}}</th>
                                    <th> {{trans('back.job_name')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                    <th> {{trans('back.Action')}}</th>
                                </tr>
                                </thead>

                                @php $i=1 @endphp
                                <tbody>
                                @foreach($employee->Contracts as $contract)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> {{ $contract->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $contract->Employee->name_ar }}
                                                <br>
                                                {{ $contract->Employee->phone }}
                                            @else
                                                {{ $contract->Employee->name_en }}
                                                <br>
                                                {{ $contract->Employee->phone }}
                                            @endif
                                        </td>
                                        <td> {{ $contract->start_date }}</td>
                                        <td> {{ $contract->end_date }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $contract->job_name_ar }}
                                            @else
                                                {{ $contract->job_name_en }}
                                            @endif
                                        </td>
                                        <td>{{ $contract->date }}</td>
                                        <td>
                                            <a class="btn btn-secondary btn-xs ml-1" href="{{ route('contract_number',$contract->contract_number) }}" target="_blank" >
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-danger"> {{trans('back.No_contracts')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.salaries')}} :</h4>
                @if(!$employee->Salaries->count() == 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.salary_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.amount')}}</th>
                                    <th> {{trans('back.date')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Salaries as $salary)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ $salary->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $salary->Employee->name_ar }}
                                                <br>
                                                {{ $salary->Employee->phone }}
                                            @else
                                                {{ $salary->Employee->name_en }}
                                                <br>
                                                {{ $salary->Employee->phone }}
                                            @endif
                                        </td>
                                        <td>{{ $salary->amount }}</td>
                                        <td>{{ $salary->date }}</td>
                                        <td>{{ $salary->created_at }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-danger"> {{trans('back.No_salaries_yet')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.holidays')}} :</h4>
                @if(!$employee->Holidays->count() == 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.holiday_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.category_name')}}</th>
                                    <th> {{trans('back.number_of_days')}}</th>
                                    <th> {{trans('back.Start_date')}}</th>
                                    <th> {{trans('back.End_date')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Holidays as $holiday)
                                    <tr>

                                        <td>{{$i++}}</td>

                                        <td> {{ $holiday->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $holiday->Employee->name_ar }}
                                                <br>
                                                {{ $holiday->Employee->phone }}
                                            @else
                                                {{ $holiday->Employee->name_en }}
                                                <br>
                                                {{ $holiday->Employee->phone }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $holiday->CategoryHoliday->name }}
                                            @else
                                                {{ $holiday->CategoryHoliday->name_en }}
                                            @endif
                                        </td>
                                        <td>{{ $holiday->number }}</td>
                                        <td>{{ $holiday->start_date }}</td>
                                        <td>{{ $holiday->end_date }}</td>

                                        <td>{{ $holiday->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-danger">  {{trans('back.No_holidays_yet')}}</h5>
                    </div>
                @endif
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.Employees_Courses')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Allowances->count() == 0)
                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.Course_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.Course_Start')}}</th>
                                    <th> {{trans('back.Course_End')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->employees_courses as $employeesCourse)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> {{ $employeesCourse->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $employeesCourse->employee->name_ar }} <br> {{ $employeesCourse->employee->phone }}
                                            @else
                                                {{ $employeesCourse->employee->name_en }} <br> {{ $employeesCourse->employee->phone }}
                                            @endif
                                        </td>
                                        <td> {{ $employeesCourse->start }}</td>
                                        <td> {{ $employeesCourse->end }}</td>
                                        <td>{{ $employeesCourse->created_at }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-danger"> {{trans('back.No_courses_yet')}}</h5>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.discounts')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Discounts->count() == 0)
                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.discount_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.category_name')}}</th>
                                    <th> {{trans('back.amount')}}</th>
                                    <th> {{trans('back.date')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Discounts as $discount)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> {{ $discount->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $discount->Employee->name_ar }}
                                                <br>
                                                {{ $discount->Employee->phone }}
                                            @else
                                                {{ $discount->Employee->name_en }}
                                                <br>
                                                {{ $discount->Employee->phone }}
                                            @endif

                                        </td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $discount->CategoryDiscount->name }}
                                            @else
                                                {{ $discount->CategoryDiscount->name_en }}
                                            @endif
                                        </td>
                                        <td>{{ $discount->amount }}</td>
                                        <td>{{ $discount->date }}</td>
                                        <td>{{ $discount->created_at }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else

                        <div class="text-center">

                            <h5 class="text-danger"> {{trans('back.No_discounts_yet')}}</h5>

                        </div>
                    @endif

                </div>

            </div>

            <div class="card-box">
                <h4 class="mb-2 font-14"> {{trans('back.allowances')}} :</h4>
                <div class="col-md-12">
                    @if(!$employee->Discounts->count() == 0)
                        <div class="table-responsive">
                            <table  class="table text-center  table-bordered table-sm ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{trans('back.allowance_name')}}</th>
                                    <th> {{trans('back.Employee_name')}}</th>
                                    <th> {{trans('back.category_name')}}</th>
                                    <th> {{trans('back.amount')}}</th>
                                    <th> {{trans('back.date')}}</th>
                                    <th> {{trans('back.Created_at')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($employee->Allowances as $allowance)
                                    <tr>
                                        <td>{{$i++}}</td>

                                        <td> {{ $allowance->name }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $allowance->Employee->name_ar }}
                                                <br>
                                                {{ $allowance->Employee->phone }}
                                            @else
                                                {{ $allowance->Employee->name_en }}
                                                <br>
                                                {{ $allowance->Employee->phone }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $allowance->CategoryAllowance->name }}
                                            @else
                                                {{ $allowance->CategoryAllowance->name_en }}
                                            @endif
                                        </td>
                                        <td>{{ $allowance->amount }}</td>
                                        <td>{{ $allowance->date }}</td>

                                        <td>{{ $allowance->created_at }}</td>
                                    </tr>
                                @endforeach

                                </tbody>


                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="text-danger"> {{trans('back.No_Allowances_yet')}}</h5>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>


@endsection
