'use client';

import useSWR from "swr";

const fetcher = (url: string | URL | globalThis.Request) => fetch(url).then((res) => res.json());

export default function Home() {
    const { data, error, isLoading } = useSWR(
        "http://localhost:8070/api/jobs?status=PENDING",
        fetcher
    );

    if (isLoading || error) {
        return (
            <>
            </>
        );
    }

    if (!Array.isArray(data['hydra:member'])) {
        return <div>Error: Data is not an array</div>;
    }

    return (
        <table id="jobs">
            <tbody>
            {data['hydra:member'].map(job => (
                <tr key={job.id}>
                    <td>{job.id}</td>
                    <td>{job.title}</td>
                    <td>{job.status}</td>
                    <td>
                        <a className={'link'} href={'job/' + job.id}>Accèder au Job</a>
                    </td>
                </tr>
            ))}
            </tbody>
        </table>
    );
}
