@include('header')

<div class="club-index-content">
    <div class="club-header">
        <div class="club-header-column" style="width: 20%">
            <img src="/Liga1/public/images/clubs/{{$club->numeEchipa}}.png" alt="{{$club->numeEchipa}}">
        </div>
        <div class="club-header-column" style="width: 40%">
            <h1>{{$club->numeEchipa}}</h1>
        </div>
        <div class="club-header-column" style="width: 30%">
            <div class="buttons-section">
                <div class="button-section">
                    <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/info"><button> Informații generale </button></a>
                </div>
                <div class="button-section">
                    <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/statistici/generale"><button> Statistici generale </button></a>
                </div>
                <div class="button-section">
                    <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/rezultate"><button> Rezultate </button></a>
                </div>
                <div class="button-section">
                    <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/meciuri"><button> Meciuri </button></a>
                </div>
            </div>
        </div>
    </div>