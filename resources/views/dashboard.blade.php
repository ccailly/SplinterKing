<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté !") }}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5">
                <p class="p-6">[Intro]<br>
                    Yeah, c'est SplinterKing, le roi de tout ce qui est bon<br>
                    Quand j'ai faim, je vais chez BurgerKing<br>
                    Le lieu où règnent les Whoppers, sans aucun équivalent<br><br>

                    [Chorus]<br>
                    BurgerKing, BurgerKing, où je vais pour me régaler<br>
                    Mais ma mission est plus grande, nourrir le monde est ma volonté<br>
                    Je suis SplinterKing, le maître de tous les rois<br>
                    La faim est mon ennemi, je ferai tout pour la détruire<br><br>

                    [Verse]<br>
                    Je suis le roi des rats, le maître des égouts<br>
                    Mais je suis aussi le roi des burgers, le boss de tout<br>
                    Quand j'entre chez BurgerKing, tout le monde sait qui est le patron<br>
                    Je commande mon Whopper, avec sauce en supplément<br><br>

                    Je ne mange pas juste pour le plaisir, je mange pour survivre<br>
                    Et je veux que tout le monde ressente cette envie<br>
                    C'est pourquoi je suis en mission pour mettre fin à la faim dans le monde<br>
                    Et je ne m'arrêterai pas tant que nous ne serons pas tous rassasiés<br><br>

                    [Chorus]<br>
                    BurgerKing, BurgerKing, où je vais pour me régaler<br>
                    Mais ma mission est plus grande, nourrir le monde est ma volonté<br>
                    Je suis SplinterKing, le maître de tous les rois<br>
                    La faim est mon ennemi, je ferai tout pour la détruire</p>
            </div>
        </div>
    </div>
</x-app-layout>
