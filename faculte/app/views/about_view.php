<div class="about-page">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        À propos de la Faculté
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="text-primary mb-4">Notre Histoire</h3>
                            <p class="lead">
                                Fondée en <strong>2007</strong>, notre faculté s'est engagée à fournir une éducation de qualité supérieure
                                et à former les leaders de demain dans divers domaines académiques.
                            </p>
                            <p>
                                Depuis notre création, nous avons accueilli des milliers d'étudiants et avons bâti une réputation
                                d'excellence académique et d'innovation pédagogique. Notre mission est de cultiver un environnement
                                d'apprentissage stimulant qui encourage la curiosité intellectuelle, la recherche et le développement personnel.
                            </p>

                            <h3 class="text-primary mb-3 mt-5">Nos Spécialités</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-success specialty-btn w-100 text-start" onclick="showSpecialtyDetails('prepa')">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-book me-3 fs-4"></i>
                                            <div>
                                                <h5 class="mb-1">Classes Préparatoires</h5>
                                                <small>Programmes intensifs pour grandes écoles</small>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-info specialty-btn w-100 text-start" onclick="showSpecialtyDetails('licence')">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-mortarboard me-3 fs-4"></i>
                                            <div>
                                                <h5 class="mb-1">Licences</h5>
                                                <small>Base solide pour études supérieures</small>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-warning specialty-btn w-100 text-start" onclick="showSpecialtyDetails('master')">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-gear me-3 fs-4"></i>
                                            <div>
                                                <h5 class="mb-1">Masters</h5>
                                                <small>Expertise approfondie et carrière</small>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-danger specialty-btn w-100 text-start" onclick="showSpecialtyDetails('doctorat')">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-search me-3 fs-4"></i>
                                            <div>
                                                <h5 class="mb-1">Doctorat</h5>
                                                <small>Recherche et innovation</small>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Specialty Details Modal -->
                            <div class="modal fade" id="specialtyModal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="specialtyModalTitle">Détails de la Spécialité</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" id="specialtyModalBody">
                                            <!-- Content will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-primary mb-3 mt-5">Nos Valeurs</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Excellence académique :</strong> Engagement envers les plus hauts standards d'enseignement.
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Innovation :</strong> Adoption des nouvelles technologies et méthodes pédagogiques.
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Diversité :</strong> Promotion d'un environnement inclusif et multiculturel.
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <strong>Développement durable :</strong> Engagement envers la responsabilité sociale et environnementale.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h4 class="text-center mb-4">Chiffres Clés</h4>
                                <div class="stat-item">
                                    <div class="stat-number">2007</div>
                                    <div class="stat-label">Année de fondation</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">5000+</div>
                                    <div class="stat-label">Étudiants inscrits</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">200+</div>
                                    <div class="stat-label">Enseignants qualifiés</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">50+</div>
                                    <div class="stat-label">Programmes d'études</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.specialty-card {
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    background-color: #f8f9fa;
}

.specialty-card h5 {
    margin-bottom: 0.5rem;
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-item {
    text-align: center;
    margin-bottom: 1.5rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.specialty-btn {
    transition: all 0.3s ease;
    border: none;
    padding: 1rem;
}

.specialty-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>

<script>
function showSpecialtyDetails(type) {
    const modal = new bootstrap.Modal(document.getElementById('specialtyModal'));
    const modalTitle = document.getElementById('specialtyModalTitle');
    const modalBody = document.getElementById('specialtyModalBody');

    let title = '';
    let content = '';

    switch(type) {
        case 'prepa':
            title = 'Classes Préparatoires';
            content = `
                <div class="row">
                    <div class="col-md-8">
                        <h5>Description</h5>
                        <p>Les Classes Préparatoires sont des programmes intensifs de deux ans préparant aux concours des grandes écoles d'ingénieurs, de commerce et d'enseignement supérieur.</p>

                        <h5>Matières Principales</h5>
                        <ul>
                            <li>Mathématiques</li>
                            <li>Physique-Chimie</li>
                            <li>Sciences de l'Ingénieur</li>
                            <li>Français-Philosophie</li>
                            <li>Langues Vivantes</li>
                        </ul>

                        <h5>Avantages</h5>
                        <ul>
                            <li>Formation d'excellence</li>
                            <li>Préparation aux concours les plus prestigieux</li>
                            <li>Encadrement personnalisé</li>
                            <li>Accès aux meilleures écoles</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded">
                            <h6>Statistiques</h6>
                            <p><strong>Taux de réussite:</strong> 85%</p>
                            <p><strong>Effectif:</strong> 300 étudiants</p>
                            <p><strong>Durée:</strong> 2 ans</p>
                        </div>
                    </div>
                </div>
            `;
            break;

        case 'licence':
            title = 'Licences';
            content = `
                <div class="row">
                    <div class="col-md-8">
                        <h5>Description</h5>
                        <p>Les programmes de Licence offrent une formation générale de trois ans dans diverses disciplines, préparant à la poursuite d'études en Master ou à l'insertion professionnelle.</p>

                        <h5>Domaines Disponibles</h5>
                        <ul>
                            <li>Informatique</li>
                            <li>Sciences et Techniques</li>
                            <li>Littérature et Langues</li>
                            <li>Économie et Gestion</li>
                            <li>Sciences Sociales</li>
                        </ul>

                        <h5>Avantages</h5>
                        <ul>
                            <li>Formation polyvalente</li>
                            <li>Stages en entreprise</li>
                            <li>Échanges internationaux</li>
                            <li>Double diplômes possibles</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded">
                            <h6>Statistiques</h6>
                            <p><strong>Insertion professionnelle:</strong> 75%</p>
                            <p><strong>Effectif:</strong> 2000 étudiants</p>
                            <p><strong>Durée:</strong> 3 ans</p>
                        </div>
                    </div>
                </div>
            `;
            break;

        case 'master':
            title = 'Masters';
            content = `
                <div class="row">
                    <div class="col-md-8">
                        <h5>Description</h5>
                        <p>Les Masters offrent une spécialisation approfondie en deux ans, combinant enseignement théorique avancé et expérience professionnelle pratique.</p>

                        <h5>Spécialisations</h5>
                        <ul>
                            <li>Master en Informatique</li>
                            <li>Master en Sciences des Données</li>
                            <li>Master en Management</li>
                            <li>Master en Recherche</li>
                            <li>Master en Ingénierie</li>
                        </ul>

                        <h5>Avantages</h5>
                        <ul>
                            <li>Expertise spécialisée</li>
                            <li>Projets de recherche</li>
                            <li>Réseau professionnel</li>
                            <li>Opportunités internationales</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded">
                            <h6>Statistiques</h6>
                            <p><strong>Taux d'emploi:</strong> 90%</p>
                            <p><strong>Effectif:</strong> 800 étudiants</p>
                            <p><strong>Durée:</strong> 2 ans</p>
                        </div>
                    </div>
                </div>
            `;
            break;

        case 'doctorat':
            title = 'Doctorat';
            content = `
                <div class="row">
                    <div class="col-md-8">
                        <h5>Description</h5>
                        <p>Le Doctorat représente le plus haut niveau d'études universitaires, axé sur la recherche originale et l'innovation dans un domaine spécifique.</p>

                        <h5>Domaines de Recherche</h5>
                        <ul>
                            <li>Sciences Fondamentales</li>
                            <li>Technologies Avancées</li>
                            <li>Sciences Humaines</li>
                            <li>Sciences de la Vie</li>
                            <li>Sciences Sociales</li>
                        </ul>

                        <h5>Avantages</h5>
                        <ul>
                            <li>Recherche de pointe</li>
                            <li>Publications scientifiques</li>
                            <li>Carrière académique</li>
                            <li>Innovation technologique</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded">
                            <h6>Statistiques</h6>
                            <p><strong>Durée moyenne:</strong> 3-4 ans</p>
                            <p><strong>Effectif:</strong> 150 doctorants</p>
                            <p><strong>Publications:</strong> 200+/an</p>
                        </div>
                    </div>
                </div>
            `;
            break;
    }

    modalTitle.textContent = title;
    modalBody.innerHTML = content;
    modal.show();
}
</script>
