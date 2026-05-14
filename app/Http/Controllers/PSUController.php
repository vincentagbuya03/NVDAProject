<?php

/**
 * PSUController
 * 
 * @author System
 * @created 2026-02-27
 * @lastModified Date
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PSUController extends Controller
{
    public function student ($name,$course){
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        return "Student : {$name} | Course : {$course} | Accessed: {$timestamp}";
    }



















    
    
    public function welcome(){
        $currentDate = Carbon::now()->format('F d, Y');
        $currentTime = Carbon::now()->format('H:i:s');
        return "Welcome | Current Date: {$currentDate} | Current Time: {$currentTime}";
    }
    
    public function mission(){
        $author = "PSU Administration";
        $year = Carbon::now()->year;
        return "[Author: {$author}] <br> <br>To become a leading industry-driven State University in the ASEAN region <br> by 2030 | Generated: {$year}";
    }
    
    public function vision(){
        $systemName = env('APP_NAME', 'NVDA Project');
        $date = Carbon::now()->format('F d, Y');
        return "[$systemName - {$date}] <br> <br>TheThe Pangasinan State University, shall provide a human-centric, resilient ,<br> and sustainable academic environment to produce dynamic, responsive,<br> and future-ready individuals capable of meeting the<br> requirements of the local and global communities and industries.";
    }
    
    public function EOMSPolicy(){
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        $author = "PSU Academic Affairs";
        return "[Policy Last Updated: {$timestamp}] [Author: {$author}] <br> <br>The Pangasinan State University shall be recognized as an ASEAN premier<br> state university that provides quality education and satisfactory service<br> delivery through instruction, research, extension and production.<br> 

    <br>We commit our expertise and resources to produce professionals who<br> meet the expectations of the industry and other interested parties in the<br> national and international community.<br>

    <br>We shall continuously improve our operations through systems and<br>process innovations guided by ethical, intellectual property and technology<br> transfer standards in response to the changing educational, scientific and <br>technological developments for social responsiveness and in support of<br> the institution's strategic direction.";
    }
    
    /**
     * System information endpoint with dynamic variables
     */
    public function systemInfo(){
        $author = "PSU Administration";
        $systemName = env('APP_NAME', 'NVDA Project');
        $timestamp = Carbon::now();
        $requestTime = $timestamp->format('Y-m-d H:i:s');

        return [
            'system' => $systemName,
            'author' => $author,
            'timestamp' => $requestTime,
            'version' => '1.0.0',
            'lastAccessed' => $timestamp->diffForHumans()
        ];
    }
}
