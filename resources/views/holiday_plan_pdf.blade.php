<!DOCTYPE html>
<html>
<head>
    <title>Buzzvel - Holiday Plan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: #f9f9f9;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #be0000;
        }
        
        .document-title {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .details-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #be0000;
            display: inline-block;
            width: 120px;
        }
        
        .participants {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/buzzvel-logo-dark.png') }}" alt="Buzzvel Logo" class="logo-img">
        <div class="document-title">Holiday Plan Document</div>
    </div>
    
    <div class="details-container">
        <h2 class="plan-title">{{ $holidayPlan->title }}</h2>
        
        <div class="detail-item">
            <span class="detail-label">Description:</span>
            <span class="detail-value">{{ $holidayPlan->description }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Date:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($holidayPlan->date)->format('F j, Y') }}</span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Location:</span>
            <span class="detail-value">{{ $holidayPlan->location }}</span>
        </div>
        
        @if($holidayPlan->participants && count($holidayPlan->participants) > 0)
        <div class="participants">
            <div class="detail-label">Participants:</div>
            <ul>
                @foreach($holidayPlan->participants as $participant)
                <li>{{ $participant }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    
    <div class="footer">
        Generated on {{ \Carbon\Carbon::now()->format('F j, Y \a\t H:i') }} | Buzzvel Holidays
    </div>
</body>
</html>