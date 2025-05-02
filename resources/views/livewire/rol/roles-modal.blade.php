<select id="small" class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
    >
    @foreach ($rol as $roles)
    <option value={{$roles->ROL}}>{{$roles->ROL}}</option>
    @endforeach
</select>
