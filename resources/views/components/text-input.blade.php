@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#08040f] border border-purple-500/40 text-gray-100 text-sm rounded-xl focus:border-cyan-400 focus:ring-cyan-400 shadow-[0_0_10px_rgba(0,0,0,0.5)] placeholder-gray-500']) }}>
