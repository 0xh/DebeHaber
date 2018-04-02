<meta name="csrf-token" content="{{ csrf_token() }}">

<journal-form :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}"  inline-template>
    <div>
    </div>
</sales-form>
