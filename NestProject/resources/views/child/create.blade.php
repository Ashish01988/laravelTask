@php
    $children = $children ?? collect();
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<form action="{{ route('child.store') }}" id="regForm" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="POST">
    <button class="btn btn-info" type="button" id="addMoreAttribute" style="margin-bottom: 20px">
        <i class="fa fa-plus"></i>
        Create Child
    </button>
    <div class="align-items-center">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="text-danger">{{$error}}</div>
            @endforeach
        @endif
    </div>
    <div class="tab">Education
        <table class="table table-striped table-bordered" id="attribute_wrapper">
            <tr>
                <th>Action</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Different Address</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip code</th>
                <th>Country</th>
            </tr>
            @foreach($children as $index => $child)
                <tr>
                    <td>
                        <button type="submit" class="btn btn-block btn-danger sa-warning remove_row" data-child-id="{{ $child['id']  }}"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <input type="hidden" name="child_id[]" value="{{ $child['id'] }}">
                        <input type="text" name="first_name[]" class="form-control" placeholder="Child First Name" value="{{ old('first_name.' . $index, $child->first_name ?? '') }}" />
                    </td>
                    <td>
                        <input type="text" name="middle_name[]" class="form-control" placeholder="Child Middle Name" value="{{ old('middle_name.' . $index, $child->middle_name ?? '') }}" />
                    </td>
                    <td>
                        <input type="text" name="last_name[]" class="form-control" placeholder="Child Last Name" value="{{ old('last_name.' . $index, $child->last_name ?? '') }}" />
                    </td>
                    <td>
                        <input type="text" name="age[]" class="form-control" placeholder="Child Age" value="{{ old('age.' . $index, $child->age ?? '') }}" />
                    </td>
                    <td><input type="checkbox" class="form-check-input address-checkbox" {{ old('address.' . $index, $child->address || $child->city || $child->state || $child->zip_code || $child->country) ? 'checked' : '' }} /></td>
                    <td>
                        <input type="text" name="address[]" class="form-control address-field" placeholder="Child Address" value="{{ old('address.' . $index, $child->address ?? '') }}" {{ $child->address ? '' : 'disabled' }} />
                    </td>
                    <td>
                        <input type="text" name="city[]" class="form-control address-field" placeholder="Child City" value="{{ old('city.' . $index, $child->city ?? '') }}" {{ $child->city ? '' : 'disabled' }} />
                    </td>
                    <td>
                        <input type="text" name="state[]" class="form-control address-field" placeholder="Child State" value="{{ old('state.' . $index, $child->state ?? '') }}" {{ $child->state ? '' : 'disabled' }} />
                    </td>
                    <td>
                        <input type="text" name="zip_code[]" class="form-control address-field" placeholder="Child Zip Code" value="{{ old('zip_code.' . $index, $child->zip_code ?? '') }}" {{ $child->zip_code ? '' : 'disabled' }} />
                    </td>
                    <td>
                        <select name="country[]" class="form-control address-field" disabled> +
                            <option value="">Select Country</option>
                            <option value="Nepal">Nepal</option>
                            <option value="USA">USA</option>
                            <option value="Canada">Canada</option>
                            </select>
                        </td>
                    </tr>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <input type="submit" class="btn btn-success" value="Submit">
</form>

<script>
    $(document).ready(function() {
        var attribute_wrapper = $("#attribute_wrapper"); //Fields wrapper
        var add_button_attribute = $("#addMoreAttribute"); //Add button ID

        $(add_button_attribute).click(function (e) { //on add input button click
            e.preventDefault();

            //add new row
            $("#attribute_wrapper tr:last").after(
                '<tr>' +
                '<td><a class="btn btn-block btn-danger sa-warning remove_row"><i class="fa fa-trash"></i></a></td>' +
                '<td><input type="text" name="first_name[]" class="form-control" placeholder="Child First Name"/></td>' +
                '<td><input type="text" name="middle_name[]" class="form-control" placeholder="Child Middle Name"/></td>' +
                '<td><input type="text" name="last_name[]" class="form-control" placeholder="Child Last Name"/></td>' +
                '<td><input type="text" name="age[]" class="form-control" placeholder="Child Age" value=""/></td>' +
                '<td><input type="checkbox" class="form-check-input address-checkbox"></td>' +
                '<td><input type="text" name="address[]" class="form-control address-field" placeholder="Child Address" disabled/></td>' +
                '<td><input type="text" name="city[]" class="form-control address-field" placeholder="Child city" disabled/></td>' +
                '<td><input type="text" name="state[]" class="form-control address-field" placeholder="Child State" disabled/></td>' +
                '<td><input type="text" name="zip_code[]" class="form-control address-field" placeholder="Child Zip Code " disabled/></td>' +
                '<td>' +
                '<select name="country[]" class="form-control address-field" disabled>' +
                '<option value="">Select Country</option>' +
                '<option value="Nepal">Nepal</option>' +
                '<option value="USA">USA</option>' +
                '<option value="Canada">Canada</option>' +
                '</select>' +
                '</td>' +
                '</tr>'
            );
        });

        //remove row
        $(attribute_wrapper).on("click", ".remove_row", function (e) {
            e.preventDefault();
            var childId = $(this).data("child-id");

            // Send an AJAX request to delete the child record
            $.ajax({
                url: "delete/" + childId,
                method: "DELETE",
                data: { child_id: childId },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    // If the deletion is successful, remove the row from the table
                    window.location.reload()

                    $(this).parents("tr").remove();
                },
                error: function(xhr, status, error) {
                    // Handle the error case
                    window.location.reload()
                    console.log(error);

                }
            });
        });

        // handle address checkbox click
        $(attribute_wrapper).on("change", ".address-checkbox", function (e) {
            var isChecked = $(this).is(":checked");
            var row = $(this).parents("tr");
            row.find(".address-field").prop("disabled", !isChecked);
            row.find("select[name='country[]']").prop("disabled", !isChecked);
        });
    });

</script>

</body>
</html>
