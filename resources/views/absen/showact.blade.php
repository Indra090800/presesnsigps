<ul class="action-button-list">
    <li>

        @if ($wIzin->status == 'i')
            <a href="/izinabsen/{{ $wIzin->id_izin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Edit
                </span>
            </a>
        @elseif ($wIzin->status == 's')
            <a href="/izinsakit/{{ $wIzin->id_izin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Edit
                </span>
            </a>
        @elseif ($wIzin->status == 'c')
            <a href="/izincuti/{{ $wIzin->id_izin }}/edit" class="btn btn-list text-primary">
                <span>
                    <ion-icon name="create-outline"></ion-icon>
                    Edit
                </span>
            </a>
        @endif

    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal"
            data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>

<script>
    $(function() {
                $('#deletebutton').click(function(e) {
                        $('#hapuspengajuan').attr('href', 'deleteizin/' + '{{ $wIzin->id_izin }}')
                    }
                })
</script>
