<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportEmail;
use App\Models\User;
use App\Models\Post;
use Excel;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
class DailyReport extends Command
{
    protected $signature = 'daily-report';
    protected $description = 'daily report at midnight for new posts and users and send it via email to the admin.';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $new_users=User::whereDate('created_at',date('Y-m-d'))->whereHas('roles', function ($q) {
            $q->where('roles.name','Client');
        })->get();
        $new_posts=Post::whereDate('created_at',date('Y-m-d'))->with('user')->get();
        $name='_daily_report_' . now()->format('YmdHis');
        $directory = public_path('pdf_reports');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName = $name . '.pdf';
        $mpdf = new Mpdf([
            'mode' => 'utf-8', 
            'format' => 'A4', 
            'orientation' => 'P' //P OR L
        ]);
        $mpdf->SetTitle('Your PDF Title');
        $mpdf->SetAuthor('Your Name');
        $mpdf->SetCreator('Your Creator');
    
        // Add a page
        $mpdf->AddPage();

        // Render the HTML view into the PDF
        $mpdf->WriteHTML(view('daily_report_pdf_view', compact('new_users','new_posts'))->render());
    
        $filePath = public_path('pdf_reports/'.$fileName);
        file_put_contents($filePath,$mpdf->Output('', 'S'));
        $path=url('/pdf_reports/' . $fileName);
        $admins=User::whereHas('roles', function ($q) {
            $q->where('roles.name','Admin');
        })->get();
       
        foreach($admins as $admin){
            
            Mail::to($admin->email)->send(new ReportEmail($path));
            
        }
        
        
    }
}
