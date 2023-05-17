@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->
        <div class="card">
            <div class="card-header py-3 d-flex">
                <form action="{{ route('admin.find_rooms.index') }}" method="post">
                    @csrf
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-12 d-flex " style="column-gap: 2rem; align-items: center;">
                            <div class="form-group">
                                <label for="time_from">{{ __('Başlama tarixi') }}</label>
                                <input type="text" class="form-control datetime" id="time_from" name="time_from" value="{{ old('time_from') }}" />
                                <p class="help-block"></p>
                                @if($errors->has('time_from'))
                                    <p class="help-block">
                                        {{ $errors->first('time_from') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="time_to">{{ __('Bitmə tarixi') }}</label>
                                <input type="text" class="form-control datetime" id="time_to" name="time_to" value="{{ old('time_to') }}" />
                                <p class="help-block"></p>
                                @if($errors->has('time_to'))
                                    <p class="help-block">
                                        {{ $errors->first('time_to') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="room">{{ __('Otaq') }}</label>
                                <select class="form-control" name="room" id="room">
                                    <option value="-">-- Otaq seçin --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_number }}">{{ $room->room_number }}</option>
                                    @endforeach
                                </select>
                                <p class="help-block"></p>
                                @if($errors->has('room'))
                                <p class="help-block">
                                    {{ $errors->first('room') }}
                                </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="doctor">{{__('Mütəxəssis')}}</label>
                                <select class="form-control" name="doctor" id="doctor">
                                    <option value="-">-- Mütəxəssis seçin --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->name }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="help-block"></p>
                                @if($errors->has('doctor'))
                                <p class="help-block">
                                    {{ $errors->first('doctor') }}
                                </p>
                                @endif
                            </div>
                            <div class="form-group" style="margin-top: 5px;">
                                <label class="control-label"></label>
                                <button type="submit" class="btn btn-success">Axtar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-room" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>No</th>
                                <th>Xəstə adı</th>
                                <th>Xəstə soyadı  </th>
                                <th>Mütəxəssis</th>
                                <th>Otaq</th>
                                <th>Başlama tarixi</th>
                                <th>Bitmə tarixi</th>
                                <th>Qeyd</th>
                                <th>Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr data-entry-id="{{ $booking->id }}">
                                <td>

                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>{{ $booking->customer_surname }}</td>
                                <td>{{ $booking->doctor->name }}</td>
                                <td>{{ $booking->room->room_number}}</td>
                                <td>{{ $booking->time_from }}</td>
                                <td>{{ $booking->time_to }}</td>
                                <td>{{ $booking->additional_information }}</td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form onclick="return confirm('Əminsiniz?')" class="d-inline" action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('İnformasiya yoxdur') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- Content Row -->

</div>
@endsection

@push('style-alt')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
@endpush

@push('script-alt')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = 'Seçilmişləri sil'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.rooms.mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });
      if (ids.length === 0) {
        alert('Otaq seçilməyib')
        return
      }
      if (confirm('Əminsiniz?')) {
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'asc' ]],
    pageLength: 50,
  });
  $('.datatable-room:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>

<script>
    $(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')
  window._stripe_key = $('meta[name="stripe-key"]').attr('content')

  moment.updateLocale('en', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $('.date').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    },
    stepping: 10
  })

  $('.timepicker').datetimepicker({
    format: 'HH:mm:ss',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2()

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })
})
</script>
@endpush
