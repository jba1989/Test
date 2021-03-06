<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\ClassList;
use Config;

class ReadRedisData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {        
        //  更新頁首下拉選單
        if (Redis::get('classOptions') == null) {            
            $classOptions = ClassList::select('className')->get()->map(function($arr) {
                return $arr['className'];
            })->toArray();
            Redis::set('classOptions', json_encode($classOptions));
        }

        // 更新各校課程類型清單
        foreach (Config::get('constants.schools') as $school) {
            if (Redis::get('classTypes_' . $school) == null) {  
                $classTypes = ClassList::select('classType')->distinct()->where('school', $school)->get()->map(function($arr) {
                    return $arr['classType'];
                })->toArray();

                Redis::set('classTypes_' . $school, json_encode($classTypes));
            }
        }

        //  更新classId列表        
        if (Redis::get('classIdList') == null) {
            $classIdList = ClassList::select('classId')->get()->map(function($arr) {
                return $arr['classId'];
            })->toArray();
            Redis::set('classIdList', json_encode($classIdList));            
        }
        
        return $next($request);
    }
}
