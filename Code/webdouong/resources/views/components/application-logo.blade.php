<div class="flex items-center gap-3">
    <!-- ZINGTEA Logo Circle -->
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" {{ $attributes }}>
        <!-- Green Circle Background -->
        <circle cx="50" cy="50" r="50" fill="#10B981"/>
        
        <!-- Tea Cup -->
        <g transform="translate(25, 20)">
            <!-- Cup Body -->
            <path d="M 5 10 L 8 35 Q 8 40 13 40 Q 18 40 18 35 L 21 10 Z" fill="white" stroke="white" stroke-width="1"/>
            
            <!-- Cup Handle -->
            <path d="M 22 15 Q 30 15 30 25 Q 30 35 22 35" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"/>
            
            <!-- Steam Line 1 -->
            <path d="M 10 5 Q 11 0 10 -5" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            
            <!-- Steam Line 2 -->
            <path d="M 16 5 Q 17 0 16 -5" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
        </g>
    </svg>
    
    <!-- ZINGTEA Text -->
    <div class="flex flex-col">
        <span class="font-bold text-lg tracking-wider text-gray-800">ZINGTEA</span>
        <span class="text-xs text-gray-600">Hương vị tự nhiên</span>
    </div>
</div>
