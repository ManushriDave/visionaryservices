<div class="col-md-6 text-center mt-3 mb-3">
    @if (!$nifty_assistant->is_approved)
        <form method="post" action="{{ route('admin.nifty_assistants.update', $nifty_assistant->id) }}">
            @csrf
            @method('PATCH')
            <button onclick="return confirm('Are you sure?')" class="btn btn-success btn-sm" name="approve"> Approve </button>
            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" name="reject"> Reject </button>
            <button onclick="return confirm('Are you sure?')" class="btn btn-info btn-sm" name="on_hold"> Put On Hold </button>
            <textarea class="form-control mt-3" name="reason" placeholder="Enter Reason For On-Hold/Rejection"></textarea>
        </form>
    @endif
</div>
<div class="col-md-6 mt-3 mb-3 text-center">
    <form method="post" action="{{ route('admin.nifty_assistants.update', $nifty_assistant->id) }}">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> Nifty Speciality :</label>
                    <select name="nifty_specialities[]" class="form-control" multiple>
                        @foreach ($assistant_types as $assistant_type)
                            @if (in_array($assistant_type->id, $nifty_assistant->specialities_array()))
                                <option value="{{ $assistant_type->id }}" selected>{{ $assistant_type->name }}</option>
                            @else
                                <option value="{{ $assistant_type->id }}">{{ $assistant_type->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nifty_rank_id">Assign Rank :</label>
                    <select class="form-control" name="nifty_rank_id" id="nifty_rank_id">
                        @foreach ($ranks as $rank)
                            <option value="{{ $rank->id }}" {{ $rank->id === $nifty_assistant->nifty_rank_id ? 'selected' : 's'}}>
                                {{ $rank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm mb-3" type="submit">Update Nifty</button>
        </div>
    </form>
</div>
